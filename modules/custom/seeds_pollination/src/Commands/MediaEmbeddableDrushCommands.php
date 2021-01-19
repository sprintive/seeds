<?php

namespace Drupal\seeds_pollination\Commands;

use DOMDocument;
use DOMXPath;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\media\Entity\Media;
use Drush\Commands\DrushCommands;
use Embed\Embed;
use Exception;

/**
 * A drush command file.
 */
class MediaEmbeddableDrushCommands extends DrushCommands {

  const ALLOWED_FIELD_TYPES = ['text_with_summary', 'text_long'];

  /**
   * Drush command that displays the given text.
   *
   * @command url_embed:migrate
   * @aliases url:m
   * @usage url_embed:migrate
   */
  public function migrateUrlEmbed() {
    // Check if url_embed is installed.
    if (!\Drupal::moduleHandler()->moduleExists('url_embed')) {
      throw new Exception('Module "url_embed" does not exist');
    }

    // Check if media_embeddable is installed.
    if (!\Drupal::moduleHandler()->moduleExists('media_embeddable')) {
      throw new Exception('Module "media_embeddable" does not exist');
    }

    $database = \Drupal::database();
    $this->urlEmbedConfig = \Drupal::config('url_embed.settings');

    // Load all field storages.
    $storages = FieldStorageConfig::loadMultiple();
    foreach ($storages as $field_storage) {
      $type = $field_storage->getType();
      if (in_array($type, self::ALLOWED_FIELD_TYPES)) {
        $table_name = str_replace('.', '__', $field_storage->id());
        $field_name = $field_storage->getName();
        $query = $database->select($table_name, 'T');
        $query->fields('T', ['entity_id', "{$field_name}_value"]);
        $query->condition("T.{$field_name}_value", "%<drupal-url%", 'LIKE');
        $results = $query->execute()->fetchAllKeyed(0, 1);
        if (!empty($results)) {
          $this->confirm(sprintf('Found "%s" entities of "%s" using url_embed, continue?', count($results), $field_storage->getTargetEntityTypeId()));
          foreach ($results as $entity_id => $html) {
            $this->urlEmbedToEmbeddable($field_storage->getTargetEntityTypeId(), $entity_id, $field_name);
          }
        }
      }
    }
  }

  /**
   * Undocumented function
   *
   * @param string $content
   * @return \DOMElement
   */
  private function createMediaEmbeddable($content, \DOMDocument $doc) {
    $media = Media::create([
      'bundle' => 'media_embeddable',
      'field_media_embeddable' => $content,
    ]);
    $media->save();

    $element = $doc->createElement('drupal-media');
    $element->setAttribute('data-align', 'center');
    $element->setAttribute('data-entity-type', 'media');
    $element->setAttribute('data-entity-uuid', $media->uuid());
    return $element;
  }

  private function urlEmbedToEmbeddable($entity_type, $entity_id, $field_name) {
    $entity = \Drupal::entityTypeManager()->getStorage($entity_type)->load($entity_id);
    if (isset($entity)) {
      $doc = new DOMDocument();
      $doc->encoding = 'UTF-8';
      $body = $entity->get($field_name)->value;
      $success = $doc->loadHTML("<div><meta charset=\"utf-8\" />" . $body . "</div>", LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

      if (!$success) {
        $this->output->writeln(sprintf('Failed to parse the html of the entity "%s:%s"', $entity_type, $entity_id));
        return;
      }

      $query = new DOMXPath($doc);
      $results = $query->query('//drupal-url[@data-embed-url]');
      foreach ($results as $drupal_url) {
        /** @var \DOMElement $drupal_url */
        $embed_url = $drupal_url->getAttribute('data-embed-url');
        $embed = Embed::create($embed_url, [
          'facebook' => [
            'key' => $this->urlEmbedConfig->get('facebook_app_id') . '|' . $this->urlEmbedConfig->get('facebook_app_secret'),
          ],
        ]);
        if ($code = $embed->getCode()) {
          $element = $this->createMediaEmbeddable($code, $doc);
          $drupal_url->parentNode->replaceChild($element, $drupal_url);
        } else {
          $this->output->writeln(sprintf('Failed to fetch the url "%s".', $embed_url));
        }
      }

      $entity->{$field_name}->value = $doc->saveHTML();
      $entity->save();
    }
  }
}