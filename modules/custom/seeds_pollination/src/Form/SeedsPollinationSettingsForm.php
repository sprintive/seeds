<?php

namespace Drupal\seeds_pollination\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a settings form for seeds_pollination module.
 */
class SeedsPollinationSettingsForm extends ConfigFormBase {

  /**
   * {@inheritDoc}
   */
  public function getFormId() {
    return 'seeds_pollination_settings';
  }

  /**
   * {@inheritDoc}
   */
  protected function getEditableConfigNames() {
    return ['seeds_pollination.settings'];
  }

  /**
   * {@inheritDoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $config = $this->config('seeds_pollination.settings');
    $form['display_unmasquerade_button'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Display Unmasquerade Button'),
      '#default_value' => $config->get('display_unmasquerade_button'),
    ];

    return $form;
  }

  /**
   * {@inheritDoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->configFactory()->getEditable('seeds_pollination.settings');
    $form_state->cleanValues();
    $values = $form_state->getValues();
    foreach ($values as $key => $value) {
      $config->set($key, $value);
    }

    $config->save();
    parent::submitForm($form, $form_state);
  }

}
