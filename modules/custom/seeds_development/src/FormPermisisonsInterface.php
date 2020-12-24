<?php

namespace Drupal\seeds_development;

/**
 * Interface FormPermisisonsInterface.
 */
interface FormPermisisonsInterface {

  /**
   * Gets the permissions of a node bundle.
   *
   * @param string $bundle
   *   The bundle
   *
   * @return array
   *   An array of permissions.
   */
  public function getNodePermissions($bundle);

  /**
   * Gets the permissions of a vocabulary.
   *
   * @param string $vid
   *   The vocabulary id.
   *
   * @return array
   *   An array of permissions.
   */
  public function getVocabularyPermissions($vid);

  /**
   * Builds the checkboxes form element.
   *
   * @param array $permissions
   *   The array of permissions.
   *
   * @return array
   *   The form element.
   */
  public function buildPermissionsCheckboxes(array $permissions);

}
