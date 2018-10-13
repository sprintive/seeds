<?php

namespace Drupal\seeds_media\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\image\Entity\ImageStyle;

/**
 *
 */
class SeedsMediaConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'seeds_media_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $config = $this->config('seeds_media.settings');
    $styles = ImageStyle::loadMultiple();
    $styles_titles = [];

    foreach ($styles as $machine_name => $val) {
      $styles_titles[$machine_name] = $val->label();
    }

    $form['allowed_image_styles'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Allowed embed image styles'),
      '#options' => $styles_titles,
      '#default_value' => $config->get('embed.allowed_image_styles'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('seeds_media.settings');
    $config->set('embed.allowed_image_styles', $form_state->getValue('allowed_image_styles'));
    $config->save();

    return parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'seeds_media.settings',
    ];
  }

}
