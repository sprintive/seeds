<?php

namespace Drupal\seeds\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Installer\InstallerKernel;
use Drupal\Core\Language\LanguageManager;
use Drupal\language\Entity\ConfigurableLanguage;

class MultilingualForm extends FormBase {

    /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'multilingual_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $standard_languages = LanguageManager::getStandardLanguageList();
    $select_options = [];

    foreach ($standard_languages as $langcode => $language_names) {
      $select_options[$langcode] = $language_names[0];
    }

    $form['#title'] = $this->t('Multilingual configuration');

    $form['enable_multilingual_languages'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable multiple languages for this site'),
      '#default_value' => FALSE,
    ];

    $form['multilingual_languages'] = [
      '#type' => 'select',
      '#title' => $this->t("Please select other language(s)"),
      '#options' => $select_options,
      '#multiple' => TRUE,
      "#size" => 12,
      '#states' => [
        'visible' => [
          ':input[name="enable_multilingual_languages"]' => [
            'checked' => true
          ],
        ],
        'invisible' => [
          ':input[name="enable_multilingual_languages"]' => [
            'checked' => false
          ],
        ],
      ],
    ];

    $form['actions'] = [
      'continue' => [
        '#type' => 'submit',
        '#value' => $this->t('Save and continue'),
        '#button_type' => 'primary',
      ],
      '#type' => 'actions',
      '#weight' => 5,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $operations = [];
    $enable_multilingual_languages = $form_state->getValue('enable_multilingual_languages');
    $multilingual_languages = $form_state->getValue('multilingual_languages');

    if (isset($enable_multilingual_languages) && isset($multilingual_languages) && $enable_multilingual_languages == TRUE) {
      foreach ($multilingual_languages as $language_code) {
        $operations[] = [
          [$this, 'batchOperation'],
          [ConfigurableLanguage::createFromLangcode($language_code)->save()],
          ];
        }
    }

    if ($operations) {
      $batch = [
        'operations' => $operations,
        'title' => $this->t('Installing additional language'),
        'error_message' => $this->t('The installation has encountered an error.'),
      ];
      if (InstallerKernel::installationAttempted()) {
        $buildInfo = $form_state->getBuildInfo();
        $buildInfo['args'][0]['enable_multilingual_languages'] = true;
        $buildInfo['args'][0]['multilingual_languages'] = $batch;
        $form_state->setBuildInfo($buildInfo);
      }
      else {
        batch_set($operations);
      }
    }
  }

}
