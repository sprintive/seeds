<?php

namespace Drupal\seeds\Installer\Form;

use Drupal\Component\Utility\Environment;
use Drupal\Core\Extension\Extension;
use Drupal\Core\Extension\ModuleExtensionList;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Installer\InstallerKernel;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Extension\ModuleInstallerInterface;

class ModuleConfigureForm extends FormBase {

  /**
   * The module extension list.
   *
   * @var \Drupal\Core\Extension\ModuleExtensionList
   */
  protected $moduleExtensionList;

    /**
   * The module installer.
   *
   * @var \Drupal\Core\Extension\ModuleInstallerInterface
   */
  protected $moduleInstaller;
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $form = parent::create($container);
    $form->setModuleExtensionList($container->get('extension.list.module'));
    $form->setModuleInstaller($container->get('module_installer'));
    return $form;
  }

  /**
   * Set the module extension list.
   *
   * @param \Drupal\Core\Extension\ModuleExtensionList $moduleExtensionList
   *   The module extension list.
   */
  protected function setModuleExtensionList(ModuleExtensionList $moduleExtensionList) {
    $this->moduleExtensionList = $moduleExtensionList;
  }

    /**
   * Set the modules installer.
   *
   * @param \Drupal\Core\Extension\ModuleInstallerInterface $moduleInstaller
   *   The module installer.
   */
  protected function setModuleInstaller(ModuleInstallerInterface $moduleInstaller) {
    $this->moduleInstaller = $moduleInstaller;
  }
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'seeds_module_configure_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('This is a list of modules that are supported by seeds, but not enabled by default.'),
    ];

    $form['install_modules'] = [
      '#type' => 'container',
      '#tree' => TRUE,
    ];

    $modules = $this->moduleExtensionList->getList();
    $seeds_features = array_filter($modules, function (Extension $module) {
      return $module->info['package'] === 'Seeds';
    });

    foreach ($seeds_features as $id => $module) {

      $form['install_modules'][$id] = [
        '#type' => 'container',
      ];

      $form['install_modules'][$id]['enable'] = [
        '#type' => 'checkbox',
        '#title' => $module->info['name'],
        '#default_value' => $module->status,
        '#disabled' => $module->status,
      ];

      $form['install_modules'][$id]['info'] = [
        '#type' => 'container',
        '#attributes' => ['class' => ['module-info']],
      ];

      $form['install_modules'][$id]['info']['description'] = [
        '#markup' => '<span class="text module-description">' . $module->info['description'] . '</span>',
      ];
    }

    $form['#title'] = $this->t('Install & configure modules');

    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['save'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save and continue'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $operations = [];
    foreach ($form_state->getValue('install_modules') as $module => $values) {
      $extension = $this->moduleExtensionList->get($module);
      if (!$extension->status && $values['enable']) {
        $operations[] = [
          [$this, 'batchOperation'],
          [$module],
        ];
      }
    }

    if ($operations) {
      $batch = [
        'operations' => $operations,
        'title' => $this->t('Installing additional modules'),
        'error_message' => $this->t('The installation has encountered an error.'),
      ];

      if (InstallerKernel::installationAttempted()) {
        $buildInfo = $form_state->getBuildInfo();
        $buildInfo['args'][0]['seeds_install_module_batch'] = $batch;
        $form_state->setBuildInfo($buildInfo);
      }
      else {
        batch_set($batch);
      }
    }
  }
   /**
   * Batch operation callback.
   *
   * @param string $module
   *   Name of the module.
   * @param array $context
   *   The batch context.
   *
   * @throws \Drupal\Core\Extension\MissingDependencyException
   */
  public function batchOperation($module, array &$context) {
    Environment::setTimeLimit(0);
    $this->moduleInstaller->install([$module]);
  }

}

