<?php

/**
 * @file
 * Site configuration for Seeds installation.
 */

/**
 * Implements hook_form_FORM_ID_alter() for install_configure_form().
 *
 * Allows the profile to alter the site configuration form.
 */
function seeds_form_install_configure_form_alter(&$form, $form_state) {
  $form['site_information']['site_mail']['#default_value'] = 'webmaster@sprintive.com';
  $form['admin_account']['account']['name']['#value'] = 'sprintive';
  $form['admin_account']['account']['mail']['#default_value'] = 'webmaster@sprintive.com';
}
