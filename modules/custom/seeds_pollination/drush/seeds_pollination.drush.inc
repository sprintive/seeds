<?php

use Drupal\field\Entity\FieldStorageConfig;
use Drupal\seeds_pollination\Commands\MediaEmbeddableDrushCommands;

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
  $commands = new MediaEmbeddableDrushCommands();
  // Check if url_embed is installed.
  if (!\Drupal::moduleHandler()->moduleExists('url_embed')) {
    throw new Exception('Module "url_embed" does not exist');
  }

  // Check if media_embeddable is installed.
  if (!\Drupal::moduleHandler()->moduleExists('media_embeddable')) {
    throw new Exception('Module "media_embeddable" does not exist');
  }

  $database = \Drupal::database();
  $settings = \Drupal::config('url_embed.settings');

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
          if (drush_get_option('migrate')) {
            // Migrate.
            echo ('Migrate');
          } else {
            echo ('Dont');
          }
        }
      } else {
        echo "Url embed is not used on this website.";
      }
    }
  }
}