<?php

namespace Drupal\seeds_development;

use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\user\PermissionHandler;

/**
 * Class FormPermissions.
 */
class FormPermissions {

  const CONTENT_PERMISSIONS = [
    'create %s content',
    'edit any %s content',
    'edit own %s content',
    'revert %s revisions',
    'view %s revisions',
    'translate %s node',
  ];

  const OVERRIDE_NODE_OPTIONS_PERMISSIONS = [
    'override %s published option',
    'override %s promote to front page option',
    'override %s sticky option',
    'override %s revision option',
    'enter %s revision log entry',
    'override %s authored on option',
    'override %s authored by option',
  ];

  const VOCABULARY_PERMISSIONS = [
    'create terms in %s',
    'edit terms in %s',
    'reorder terms in %s',
    'translate %s taxonomy_term',
    'view terms in %s',

  ];

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;
  /**
   * Drupal\user\PermissionHandler definition.
   *
   * @var \Drupal\user\PermissionHandler
   */
  protected $userPermissions;

  /**
   * The module handler.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Constructs a new FormPermissions object.
   */
  public function __construct(EntityTypeManager $entity_type_manager, PermissionHandler $user_permissions, ModuleHandlerInterface $module_handler) {
    $this->entityTypeManager = $entity_type_manager;
    $this->userPermissions = $user_permissions;
    $this->moduleHandler = $module_handler;
  }

  /**
   * {@inheritDoc}
   */
  public function getNodePermissions($bundle) {
    $permissions = array_map(function ($permission) use ($bundle) {
      return sprintf($permission, $bundle);
    }, self::CONTENT_PERMISSIONS);

    if ($this->moduleHandler->moduleExists('override_node_options')) {
      $override_node_options_permissions = array_map(function ($permission) use ($bundle) {
        return sprintf($permission, $bundle);
      }, self::OVERRIDE_NODE_OPTIONS_PERMISSIONS);

      $permissions = array_merge($permissions, $override_node_options_permissions);
    }

    return $permissions;
  }

  /**
   * {@inheritDoc}
   */
  public function getVocabularyPermissions($vid) {

    return array_map(function ($permission) use ($vid) {
      return sprintf($permission, $vid);
    }, self::VOCABULARY_PERMISSIONS);
  }

  /**
   * {@inheritDoc}
   */
  public function buildPermissionsCheckboxes(array $permissions) {
    $element = [
      '#tree' => TRUE,
      '#type' => 'details',
      '#title' => t('Permissions'),
      '#group' => 'additional_settings',
    ];

    $all_permissions = $this->userPermissions->getPermissions();
    $readable_permissions = [];
    foreach ($permissions as $permission) {
      $readable_permissions[$permission] = $all_permissions[$permission]['title'];
    }

    /** @var \Drupal\user\RoleInterface[] $roles */
    $roles = $this->entityTypeManager->getStorage('user_role')->loadMultiple();
    foreach ($roles as $role) {
      $permissions_in_role = array_filter($permissions, function ($permission) use ($role) {
        return $role->hasPermission($permission);
      });

      $element[$role->id()] = [
        '#type' => 'details',
        '#tree' => TRUE,
        '#open' => TRUE,
        '#title' => $role->label(),
        '#summary' => t('Change the permissions of this entity type'),
        'permissions' => [
          '#type' => 'checkboxes',
          '#options' => $readable_permissions,
          '#default_value' => $permissions_in_role,
        ],
      ];
    }

    return $element;
  }

}
