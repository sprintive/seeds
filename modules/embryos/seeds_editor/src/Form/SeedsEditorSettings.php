<?php

namespace Drupal\seeds_editor\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SeedsSettings.
 */
class SeedsEditorSettings extends ConfigFormBase {

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'seeds_editor.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'seeds_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config("seeds_editor.settings");
    $blazy_config = $this->config('seeds_editor.blazy');

    $form['ckeditor'] = [
      '#type' => 'fieldset',
      '#title' => t('CKEditor'),
      '#tree' => FALSE,
    ];

    $form['ckeditor']['ltr_style'] = [
      '#type' => 'textfield',
      '#title' => $this->t('LTR Style'),
      '#maxlength' => 128,
      '#size' => 32,
      '#default_value' => $config->get('ltr_style'),
    ];

    $form['ckeditor']['rtl_style'] = [
      '#type' => 'textfield',
      '#title' => $this->t('RTL Style'),
      '#maxlength' => 128,
      '#size' => 32,
      '#default_value' => $config->get('rtl_style'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('seeds_editor.settings')
      ->set('ltr_style', $form_state->getValue('ltr_style'))
      ->set('rtl_style', $form_state->getValue('rtl_style'))
      ->save();
    $this->messenger()->addStatus($this->t("Seeds configuration has been saved successfully"));
  }

}
