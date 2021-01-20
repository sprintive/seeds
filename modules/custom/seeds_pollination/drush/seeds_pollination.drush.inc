<?php

use Drupal\field\Entity\FieldStorageConfig;
use Drupal\media\Entity\Media;
use Embed\Embed;

const ALLOWED_FIELD_TYPES = ['text_with_summary', 'text_long'];

function seeds_pollination_drush_command() {
  $commands = [];
  $commands['url_embed_migrate'] = [
    'description' => 'Check if url embed is used, and optinally, try to migrate.',
    'aliases' => ['urlem'],
    'options' => [
      'migrate' => 'Actually migrate the content (By default, it won\'t migrate)',
    ],
  ];

  return $commands;
}

function drush_seeds_pollination_url_embed_migrate() {
  $not_used = TRUE;
  // Check if url_embed is installed.
  if (!\Drupal::moduleHandler()->moduleExists('url_embed')) {
    throw new Exception('Module "url_embed" does not exist');
  }

  // Check if media_embeddable is installed.
  if (!\Drupal::moduleHandler()->moduleExists('media_embeddable')) {
    throw new Exception('Module "media_embeddable" does not exist');
  }

  $database = \Drupal::database();
  // Load all field storages.
  $storages = FieldStorageConfig::loadMultiple();
  foreach ($storages as $field_storage) {
    $type = $field_storage->getType();
    if (in_array($type, ALLOWED_FIELD_TYPES)) {
      $table_name = str_replace('.', '__', $field_storage->id());
      $field_name = $field_storage->getName();
      $query = $database->select($table_name, 'T');
      $query->fields('T', ['entity_id', "{$field_name}_value"]);
      $query->condition("T.{$field_name}_value", "%<drupal-url%", 'LIKE');
      $results = $query->execute()->fetchAllKeyed(0, 1);
      if (!empty($results)) {
        foreach ($results as $entity_id => $html) {
          $not_used = FALSE;
          if (drush_get_option('migrate')) {
            // Migrate.
            seeds_pollination_url_embed_to_embeddable($field_storage->getTargetEntityTypeId(), $entity_id, $field_name);
          } else {
            echo (sprintf("Found \"%s\" url_embeds in \"%s:%s\"\n", count($results), $table_name, $field_name));
          }
        }
      }
    }
  }
  if ($not_used) {
    echo "Url embed is not used on this website.\n";
  } else {
    echo "Run \"urlem --migrate\" to migrate";
  }
}

/**
 * Creates a media: embeddable as a DOMElement.
 *
 * @param string $content
 * @return \DOMElement
 */
function seeds_pollination_create_media_embeddable($content, \DOMDocument $doc) {
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

/**
 * Converts url_embed tag to a media embddable.
 *
 * @param string $entity_type
 * @param string $entity_id
 * @param string $field_name
 * @return void
 */
function seeds_pollination_url_embed_to_embeddable($entity_type, $entity_id, $field_name) {
  $entity = \Drupal::entityTypeManager()->getStorage($entity_type)->load($entity_id);
  $settings = \Drupal::config('url_embed.settings');
  if (isset($entity)) {
    $doc = new DOMDocument();
    $doc->encoding = 'UTF-8';
    $body = $entity->get($field_name)->value;
    $success = $doc->loadHTML("<div><meta charset=\"utf-8\" />" . $body . "</div>", LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    if (!$success) {
      echo (sprintf("Failed to parse the html of the entity \"%s:%s\"\n", $entity_type, $entity_id));
      return;
    }

    $query = new DOMXPath($doc);
    $results = $query->query('//drupal-url[@data-embed-url]');
    foreach ($results as $drupal_url) {
      /** @var \DOMElement $drupal_url */
      $embed_url = $drupal_url->getAttribute('data-embed-url');
      $embed = Embed::create($embed_url, [
        'facebook' => [
          'key' => $settings->get('facebook_app_id') . '|' . $settings->get('facebook_app_secret'),
        ],
      ]);
      if ($code = $embed->getCode()) {
        $element = seeds_pollination_create_media_embeddable($code, $doc);
        $drupal_url->parentNode->replaceChild($element, $drupal_url);
      } else {
        echo (sprintf("Failed to fetch the url \"%s\".\n", $embed_url));
      }
    }

    $entity->{$field_name}->value = $doc->saveHTML();
    $entity->save();
  }
}