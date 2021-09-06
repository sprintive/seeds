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

    $form['replace_permissions_form_route'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Replace the role permissions form with the Seeds Pollination\'s one'),
      '#default_value' => $config->get('replace_permissions_form_route'),
    ];

    $form['description_is_required_for_config_entities'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Make the description field required for config entities'),
      '#default_value' => $config->get('description_is_required_for_config_entities'),
    ];

    $form['description_config_entities_exclude'] = [
      '#type' => 'textfield',
      '#placeholder' => 'e.g. "user_role, entity_queue"',
      '#title' => $this->t('Exclude Config Entity IDs'),
      '#default_value' => $config->get('description_config_entities_exclude') ? implode(', ', $config->get('description_config_entities_exclude')) : NULL,
      '#states' => [
        'visible' => [
          ':input[name="description_is_required_for_config_entities"]' => ['checked' => TRUE],
        ],
      ],
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
      if ('description_config_entities_exclude' == $key) {
        $value = str_replace(' ', '', $value);
        $value = explode(',', $value);
      }
      $config->set($key, $value);
    }

    $config->save();
    parent::submitForm($form, $form_state);
  }

}
