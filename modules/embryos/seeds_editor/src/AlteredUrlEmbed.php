<?php

namespace Drupal\seeds_editor;

use Drupal\url_embed\Plugin\EmbedType\Url;

/**
 *
 */
class AlteredUrlEmbed extends Url {

  /**
   * {@inheritdoc}
   */
  public function getDefaultIconUrl() {
    return file_create_url(drupal_get_path('module', 'seeds_editor') . '/images/url.svg');
  }

}
