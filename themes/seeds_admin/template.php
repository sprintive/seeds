<?php

/**
 * Implementation of hook_preprocess_html().
 */
function seeds_admin_preprocess_html(&$vars, $hook) {

  // Increase the weight of enhancment to be loaded after original theme CSS.
  $css_path = drupal_get_path('theme', 'seeds_admin');
  drupal_add_css($css_path . '/css/seeds_admin.css', array('group' => CSS_THEME, 'media' => 'all', 'weight' => 9999));
}