<?php

/**
 * @file
 * Seeds profile.
 */

/**
 * Implements hook_form_FORM_ID_alter() for install_configure_form().
 */
function seeds_form_install_configure_form_alter(&$form) {
  $form['site_information']['site_name']['#placeholder'] = t('Seeds');
}
