<?php

namespace Drupal\seeds_development;

/**
 * Interface SeedsDevelopmentInspectorInterface.
 */
interface SeedsDevelopmentInspectorInterface {

  /**
   * Checks where the image style is used
   *
   * @param \Drupal\image\ImageStyleInterface $image_style
   *    The image style.
   *
   * @return array
   *    An array of locations
   */
  public function imageStyleUseability(\Drupal\image\ImageStyleInterface $image_style);

}