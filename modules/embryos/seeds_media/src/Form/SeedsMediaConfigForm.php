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

    $form['blazy'] = [
      '#type' => 'fieldset',
      '#tree' => TRUE,
      '#title' => t("Blazy"),
    ];

    $form['blazy']['override'] = [
      '#type' => 'checkbox',
      '#title' => t('Override blazy loader?'),
      '#default_value' => $config->get('blazy')['override'],
    ];

    $form['blazy']['loader'] = [
      '#type' => 'textfield',
      '#title' => t('Loader Image URI'),
      '#default_value' => $config->get('blazy')['loader'],
      '#states' => [
        'disabled' => [
          '[name="override_blazy_loader"]' => ['checked' => FALSE],
        ],
      ],
    ];

    $form['blazy']['background_color'] = [
      '#type' => 'color',
      '#title' => t('Background Color'),
      '#default_value' => $config->get('blazy')['background_color'],
      '#description' => t('Use css background, e.g. "#333333"'),
      '#states' => [
        'disabled' => [
          '[name="override_blazy_loader"]' => ['checked' => FALSE],
        ],
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('seeds_media.settings');
    $values = $form_state->getValues();
    $config->set('embed.allowed_image_styles', $values['allowed_image_styles']);
    $config->set('blazy', $values['blazy']);
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
