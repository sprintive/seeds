<?php

namespace Drupal\seeds_pollination\Plugin\Layout;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\PluginFormInterface;
use Drupal\Core\Layout\LayoutDefault;

/**
 * Ne
 * Layout class for all Foundation layouts.
 */
class SeedsLighthouse extends LayoutDefault implements PluginFormInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return parent::defaultConfiguration() + [
      'wrapper_classes' => '',
      'wrapper_id' => '',
      'row_1' => 'container',
      'row_2' => 'container',
      'row_4' => 'container',
      'row_6' => 'container',
      'row_8' => 'container',
      'row_10' => 'container',
      'row_12' => 'container',
      'row_14' => 'container',
      'row_16' => 'container',
      'row_18' => 'container',
      'row_19' => 'container',
      'row_20' => 'container',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {

    $configuration = $this->getConfiguration();

    $form['attributes'] = [
      '#group' => 'additional_settings',
      '#type' => 'details',
      '#title' => $this->t('Wrapper attributes'),
      '#tree' => TRUE,
    ];

    $form['attributes']['wrapper_classes'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Wrapper classes'),
      '#description' => $this->t('Add additional classes to the outermost element.'),
      '#default_value' => $configuration['wrapper_classes'],
      '#weight' => 1,
    ];

    $form['attributes']['wrapper_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Wrapper Id'),
      '#description' => $this->t('Add an Id to the outermost element.'),
      '#default_value' => $configuration['wrapper_id'],
      '#weight' => 1,
    ];

    $container_classes = [
      'container' => 'container',
      'fluid-container' => 'fluid-container',
    ];

    foreach ($this->getRows() as $row) {
      $form['attributes'][$row] = [
        '#type' => 'select',
        '#title' => $this->t(ucfirst(str_replace('_', ' ', $row))),
        '#options' => $container_classes,
        '#default_value' => $configuration[$row],
      ];
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['attributes'] = $form_state->getValue('attributes');

    $classes = array_merge(['wrapper_id', 'wrapper_classes'], $this->getRows());

    foreach ($classes as $name) {
      $this->configuration[$name] = $this->configuration['attributes'][$name];
      unset($this->configuration['attributes'][$name]);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {}

  /**
   * {@inheritdoc}
   */
  public function getRows() {
    return ['row_1', 'row_2', 'row_4', 'row_6', 'row_8', 'row_10', 'row_12', 'row_14', 'row_16', 'row_18', 'row_19', 'row_20'];
  }

}
