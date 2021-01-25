<?php

namespace Drupal\seeds_pollination\Commands;

use Drush\Commands\DrushCommands;
use Embed\Embed;

/**
 * A drush command file.
 */
class MediaEmbeddableDrushCommands extends DrushCommands {

  const ALLOWED_FIELD_TYPES = ['text_with_summary', 'text_long'];

  /**
   * Drush command that displays the given text.
   *
   * @command url_embed_migrate
   * @aliases urlem
   * @usage url_embed:migrate
   */
  public function migrateUrlEmbed() {
    drush_seeds_pollination_url_embed_migrate();
  }
}