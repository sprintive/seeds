<?php

/**
 * Implementation of hook_preprocess_page.
 */
function seeds_preprocess_page(&$variables) {

  $variables['wrapper_container'] = 'container';
  $variables['body_column'] = 'col-sm-12';
  if ($panel_page = page_manager_get_current_page()) {
    $variables['wrapper_container'] = 'container-fluid';
    $variables['body_column'] = '';
    $variables['content_column_class'] = '';
  }

  if(($key = array_search('container', $variables['navbar_classes_array'])) !== false) {
      unset($variables['navbar_classes_array'][$key]);
  }
}