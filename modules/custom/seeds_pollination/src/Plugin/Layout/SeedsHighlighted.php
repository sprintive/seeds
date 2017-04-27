<?php

namespace Drupal\seeds_pollination\Plugin\Layout;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Layout\LayoutDefault;

/**
 * Layout class for all Foundation layouts.
 */
class SeedsHighlighted extends LayoutDefault {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return parent::defaultConfiguration() + [
      'wrappers' => [],
      'wrapper_classes' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);
    $configuration = $this->getConfiguration();

    $form['attributes'] = array(
      '#group' => 'additional_settings',
      '#type' => 'details',
      '#title' => $this->t('Wrapper attributes'),
      '#description' => $this->t('Attributes for the outermost element'),
      '#tree' => TRUE,
    );

    $form['attributes']['wrapper_classes'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Wrapper classes'),
      '#description' => $this->t('Add additional classes to the outermost element.'),
      '#default_value' => $configuration['wrapper_classes'],
      '#weight' => 1,
    );

    $form['attributes']['wrapper_id'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Wrapper Id'),
      '#description' => $this->t('Add an Id to the outermost element.'),
      '#default_value' => $configuration['wrapper_id'],
      '#weight' => 1,
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['attributes'] = $form_state->getValue('attributes');
    foreach (['wrapper_classes', 'wrapper_id'] as $name) {
      $this->configuration[$name] = $this->configuration['attributes'][$name];
      unset($this->configuration['attributes'][$name]);
    }
  }
}
