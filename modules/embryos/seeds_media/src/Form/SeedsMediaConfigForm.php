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

    $form['media_library'] = [
      '#type' => 'fieldset',
      '#title' => t('Media Library'),
      '#tree' => FALSE,
    ];

    $form['media_library']['check_media_usability'] = [
      '#type' => 'checkbox',
      '#title' => $this->t("Check Media Usability"),
      '#description' => $this->t("Use this if you want to warn the user if the current media which is being edited is used in another entity on the website."),
      '#default_value' => $config->get('check_media_usability'),
    ];

    $styles = ImageStyle::loadMultiple();
    $styles_titles = [];

    foreach ($styles as $machine_name => $val) {
      $styles_titles[$machine_name] = $val->label();
    }

    $form['image_styles'] = [
      '#type' => 'fieldset',
      '#title' => t('Deprecated: Allowed Embed Media Image Styles'),
      '#tree' => FALSE,
    ];

    $form['image_styles']['allowed_image_styles'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Select allowed image styles to choose from when you embed media images using entity browser.'),
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
    $values = $form_state->getValues();
    $config->set('embed.allowed_image_styles', $values['allowed_image_styles']);
    $config->set('check_media_useability', $values['check_media_useability']);
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
