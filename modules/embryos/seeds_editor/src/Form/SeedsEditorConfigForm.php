<?php

namespace Drupal\seeds_editor\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SeedsSettings.
 */
class SeedsEditorConfigForm extends ConfigFormBase {

  /**
   *
   */
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
    return 'seeds_editor_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config("seeds_editor.settings");

    $form['ckeditor'] = [
      '#type' => 'fieldset',
      '#title' => t('CKEditor'),
      '#tree' => FALSE,
    ];

    $form['ckeditor']['load_ckeditor_styles'] = [
      '#type' => 'checkbox',
      '#title' => t('Load custom styles for CKeditor?'),
      '#default_value' => $config->get('load_ckeditor_styles'),
    ];

    $form['ckeditor']['ckeditor_ltr_style'] = [
      '#type' => 'textfield',
      '#title' => $this->t('LTR Style'),
      '#maxlength' => 128,
      '#size' => 32,
      '#default_value' => $config->get('ckeditor_ltr_style'),
      '#states' => [
        'visible' => [
          '[name="load_ckeditor_styles"]' => ['checked' => TRUE],
        ],
      ],
    ];

    $form['ckeditor']['ckeditor_rtl_style'] = [
      '#type' => 'textfield',
      '#title' => $this->t('RTL Style'),
      '#maxlength' => 128,
      '#size' => 32,
      '#default_value' => $config->get('ckeditor_rtl_style'),
      '#states' => [
        'visible' => [
          '[name="load_ckeditor_styles"]' => ['checked' => TRUE],
        ],
      ],
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
      ->set('load_ckeditor_styles', $form_state->getValue('load_ckeditor_styles'))
      ->set('ckeditor_ltr_style', $form_state->getValue('ckeditor_ltr_style'))
      ->set('ckeditor_rtl_style', $form_state->getValue('ckeditor_rtl_style'))
      ->save();
    $this->messenger()->addStatus($this->t("Seeds configuration has been saved successfully"));
  }

}
