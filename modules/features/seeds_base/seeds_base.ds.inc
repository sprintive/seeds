<?php
/**
 * @file
 * seeds_base.ds.inc
 */

/**
 * Implements hook_ds_view_modes_info().
 */
function seeds_base_ds_view_modes_info() {
  $export = array();

  $ds_view_mode = new stdClass();
  $ds_view_mode->api_version = 1;
  $ds_view_mode->view_mode = 'landing';
  $ds_view_mode->label = 'Landing';
  $ds_view_mode->entities = array(
    'node' => 'node',
  );
  $export['landing'] = $ds_view_mode;

  return $export;
}
