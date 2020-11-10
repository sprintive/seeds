<?php

/**
 * @file
 * Seeds profile.
 */

/**
 * Implements hook_form_FORM_ID_alter() for install_configure_form().
 *
 */

function seeds_form_install_configure_form_alter(&$form) {
    $form['site_information']['site_name']['#placeholder'] = t('Seeds');
};

/**
 * Implements hook_install_tasks().
 */
function seeds_install_tasks(&$install_state) {
    $task = [];
    if(empty($install_state["config_install_path"])) {
        $task["multilingual_configuration_form"]=[
            'display_name' => t("Multilingual configuration"),
            'type' => 'form',
            'function' => Drupal\seeds\Form\MultilingualForm::class
        ];
        $task["seeds_configure_multilingual"]=[
            'display_name' => t("Configure multilingual"),
            'type' => 'batch',
        ];
         $task["seeds_configure_form"] = [
            'display_name' => t('Configure Module'),
            'type' => 'form',
            'function' => Drupal\seeds\Installer\Form\ModuleConfigureForm::class
         ];
         $task['seeds_module_install'] = [
            'display_name' => t('Install additional modules'),
            'type' => 'batch',
          ];
    }
    return $task;
}

function seeds_configure_multilingual(array &$install_state) {
    return $install_state['multilingual_languages'] ?? [];
}

  function seeds_module_install(array &$install_state) {
    return $install_state['seeds_install_module_batch'] ?? [];
  }