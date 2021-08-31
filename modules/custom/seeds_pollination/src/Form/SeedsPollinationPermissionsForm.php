<?php

namespace Drupal\seeds_pollination\Form;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;
use Drupal\Core\Security\TrustedCallbackInterface;
use Drupal\form_mode_manager\FormModeManagerPermissions;
use Drupal\menu_admin_per_menu\MenuAdminPerMenuPermissions;
use Drupal\user\PermissionHandlerInterface;
use Drupal\user\RoleInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * This form is for configuring permissions in an easy way.
 */
class SeedsPollinationPermissionsForm extends ConfigFormBase implements ContainerInjectionInterface, TrustedCallbackInterface {

    /**
     * The user role entity
     *
     * @var \Drupal\user\RoleInterface
     */
    protected $userRole;

    /**
     * The entity type manager
     *
     * @var \Drupal\Core\Entity\EntityTypeManagerInterface
     */
    protected $entityTypeManager;

    /**
     * The module handler
     *
     * @var \Drupal\Core\Extension\ModuleHandlerInterface
     */
    protected $moduleHandler;

    /**
     * The permissions handler
     *
     * @var \Drupal\user\PermissionHandlerInterface
     */
    protected $permissionsHandler;

    /**
     * {@inheritDoc}
     */
    public static function create(ContainerInterface $container) {
        return new static($container->get('entity_type.manager'), $container->get('module_handler'), $container->get('user.permissions'));
    }

    /**
     * {@inheritDoc}
     */
    public static function trustedCallbacks() {
        return ['preRender'];
    }

    /**
     * Constructs a new SeedsPollinationPermissionsForm object.
     *
     * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
     */
    public function __construct(EntityTypeManagerInterface $entity_type_manager, ModuleHandlerInterface $module_handler, PermissionHandlerInterface $permissions_handler) {
        $this->entityTypeManager = $entity_type_manager;
        $this->moduleHandler = $module_handler;
        $this->permissionsHandler = $permissions_handler;
    }

    /**
     * {@inheritDoc}
     */
    public function getFormId() {
        return 'seeds_pollination_permissions';
    }

    /**
     * {@inheritDoc}
     */
    protected function getEditableConfigNames() {
        /** @var \Drupal\user\RoleInterface[] $roles */
        $roles = $this->entityTypeManager->getStorage('user_role')->loadMultiple();
        $editable_config_names = [];
        foreach ($roles as $role) {
            $editable_config_names[] = $role->getConfigTarget();
        }

        return $editable_config_names;
    }

    /**
     * Gets the permissions for custom modules
     *
     * @param array $permissions
     * @return void
     */
    private function customModulesPermissions(&$permissions) {
        $directiories = $this->moduleHandler->getModuleDirectories();
        $directiories = array_filter($directiories, function ($directory) {
            return strpos($directory, DRUPAL_ROOT . '/modules/contrib') === FALSE &&
            strpos($directory, DRUPAL_ROOT . '/core/modules') === FALSE &&
            strpos($directory, DRUPAL_ROOT . '/profiles/contrib') === FALSE;
        });

        $all_permissions = $this->permissionsHandler->getPermissions();
        foreach ($directiories as $module => $directory) {
            if ($this->permissionsHandler->moduleProvidesPermissions($module)) {
                $module_permissions = array_filter($all_permissions, function ($permission) use ($module) {
                    return $permission['provider'] == $module;
                });
                $permissions['general'][$module] = [
                    'title' => $this->moduleHandler->getName($module),
                    'id' => $module,
                    'permissions' => array_keys($module_permissions),
                ];
            }

        }
    }

    /**
     * Gets the permissions as an array.
     *
     * @return array
     */
    protected function getModulesPermissions() {
        $permissions = [];
        $permissions['node'] = ['title' => $this->t('Content')];

        // Get the node types permissions.
        /** @var \Drupal\node\NodeTypeInterface[] $node_types */
        $node_types = $this->entityTypeManager->getStorage('node_type')->loadMultiple();

        $permissions['node']['general_node'] = [
            'title' => $this->t('General Permissions'),
            'id' => 'general',
            'permissions' => [
                'access content overview',
                'bypass node access',
                'access content',
                'view own unpublished content',
                'delete all revisions',
                'revert all revisions',
                'view all revisions',
                'use yoast seo',
            ],
        ];

        // View Unpublished
        if ($this->moduleHandler->moduleExists('view_unpublished')) {
            $permissions['node']['general_node']['permissions'][] = 'view any unpublished content';
        }

        // Override Node Options General Permissions
        if ($this->moduleHandler->moduleExists('override_node_options')) {
            $permissions['node']['general_node']['permissions'] = array_merge($permissions['node']['general_node']['permissions'], [
                'override all published option',
                'override all promote to front page option',
                'override all sticky option',
                'override all revision option',
                'enter all revision log entry',
                'override all authored by option',
                'override all authored on option',
            ]);
        }

        foreach ($node_types as $node_type) {
            $section = [
                'title' => $node_type->label(),
                'id' => $node_type->id(),
                'copy' => TRUE,
                'permissions' => [],
            ];

            $node_type_id = $node_type->id();
            $section['permissions'] = [
                sprintf('create %s content', $node_type_id),
                sprintf('edit any %s content', $node_type_id),
                sprintf('edit own %s content', $node_type_id),
                sprintf('translate %s node', $node_type_id),
                sprintf('view %s revisions', $node_type_id),
                sprintf('revert %s revisions', $node_type_id),
                sprintf('translate %s node', $node_type_id),
            ];

            // View Unpublished.
            if ($this->moduleHandler->moduleExists('view_unpublished')) {
                $section['permissions'][] = sprintf('view any unpublished %s content', $node_type_id);
            }

            // Override Node Options
            if ($this->moduleHandler->moduleExists('override_node_options')) {
                $section['permissions'] = array_merge($section['permissions'], [
                    sprintf('override %s published option', $node_type_id),
                    sprintf('override %s promote to front page option', $node_type_id),
                    sprintf('override %s sticky option', $node_type_id),
                    sprintf('override %s revision option', $node_type_id),
                    sprintf('enter %s revision log entry', $node_type_id),
                    sprintf('override %s authored on option', $node_type_id),
                    sprintf('override %s authored by option', $node_type_id),
                ]);
            }

            $permissions['node'][] = $section;
        }

        // Vocabularies.
        $permissions['term'] = ['title' => $this->t("Taxonomy Term")];

        $permissions['term'][] = [
            'id' => 'general_term',
            'title' => $this->t('General'),
            'permissions' => [
                'access taxonomy overview',
                'administer taxonomy',
            ],
        ];

        /** @var \Drupal\taxonomy\VocabularyInterface $vocabularies[] */
        $vocabularies = $this->entityTypeManager->getStorage('taxonomy_vocabulary')->loadMultiple();
        foreach ($vocabularies as $vocabulary) {
            $id = $vocabulary->id();
            $section = [
                'title' => $vocabulary->label(),
                'id' => $id,
                'copy' => TRUE,
                'permissions' => [
                    sprintf('create terms in %s', $id),
                    sprintf('edit terms in %s', $id),
                    sprintf('reorder terms in %s', $id),
                    sprintf('view terms in %s', $id),
                    sprintf('translate %s taxonomy_term', $id),
                ],
            ];

            $permissions['term'][] = $section;
        }

        // Media
        $permissions['media'] = ['title' => $this->t('Media')];

        $permissions['media'][] = [
            'title' => $this->t('General Permissions'),
            'id' => 'general-media',
            'permissions' => [
                'access media overview',
                'create media',
                'update any media',
                'update own media',
                'view all media revisions',
                'view media',
                'view own unpublished media',
                'access files overview',

            ],
        ];

        /** @var \Drupal\media\MediaTypeInterface $media_types */
        $media_types = $this->entityTypeManager->getStorage('media_type')->loadMultiple();
        foreach ($media_types as $media_type) {
            $id = $media_type->id();
            $section = [
                'title' => $media_type->label(),
                'id' => $id,
                'copy' => TRUE,
                'permissions' => [
                    sprintf('create %s media', $id),
                    sprintf('edit any %s media', $id),
                    sprintf('edit own %s media', $id),
                ],
            ];

            $permissions['media'][] = $section;
        }

        // Blocks and block content.
        $permissions['block'] = ['title' => $this->t('Block')];
        $permissions['block']['general'] = [
            'title' => $this->t('General'),
            'id' => 'general_block',
            'permissions' => [
                'administer blocks',
                'translate block_content',
            ],
        ];

        if ($this->moduleHandler->moduleExists('block_content_permissions')) {
            $permissions['block']['general']['permissions'] = array_merge($permissions['block']['general']['permissions'], [
                'access block content overview',
                'view restricted block content',
            ]);

            /** @var \Drupal\block_content\BlockContentTypeInterface[] $block_content_types */
            $block_content_types = $this->entityTypeManager->getStorage('block_content_type')->loadMultiple();
            foreach ($block_content_types as $block_content_type) {
                $id = $block_content_type->id();
                $section = [
                    'title' => $block_content_type->label(),
                    'id' => $id,
                    'permissions' => [
                        sprintf('create %s block content', $id),
                        sprintf('update any %s block content', $id),
                        sprintf('edit own %s media', $id),
                    ],
                ];

                $permissions['block'][] = $section;
            }
        }

        $permissions['general'] = ['title' => $this->t('General')];
        $permissions['general'][] = [
            'title' => $this->t('Administration & Toolbar'),
            'id' => 'admin_and_toolar',
            'permissions' => [
                'access toolbar',
                'view the administration theme',
                'access contextual links',
                'access administration pages',
                'access site in maintenance mode',
                'skip CAPTCHA',
                'create url aliases',
                'access shortcuts',
                'link to any page',
                'access responsive preview',
            ],
        ];

        // Menu
        $permissions['general']['menu'] = [
            'title' => $this->t('Menu'),
            'id' => 'menu',
            'permissions' => ['administer menu', 'translate menu_link_content'],
        ];

        // Menu admin per menu
        if ($this->moduleHandler->moduleExists('menu_admin_per_menu')) {
            $menu_per_admin_permissions = (new MenuAdminPerMenuPermissions())->permissions();
            $permissions['general']['menu']['permissions'] = array_merge($permissions['general']['menu']['permissions'], array_keys($menu_per_admin_permissions));
        }

        // Translations
        $permissions['general'][] = [
            'title' => $this->t('Translations'),
            'id' => 'translations',
            'permissions' => [
                'create content translations',
                'update content translations',
                'translate editable entities',
                'translate any entity',
            ],
        ];

        // User
        $permissions['general']['user'] = [
            'title' => $this->t('User'),
            'id' => 'general_user',
            'permissions' => [
                'administer users',
                'cancel account',
                'change own username',
                'select account cancellation method',
                'view user email addresses',
                'access user profiles',
            ],
        ];

        // Administer Users By Role
        if ($this->moduleHandler->moduleExists('administerusersbyrole')) {
            $access_manager = \Drupal::service('administerusersbyrole.access');
            $permissions['general']['user']['permissions'] = array_merge(
                $permissions['general']['user']['permissions'],
                [
                    'create users',
                    'access users overview',
                    'allow empty user mail',
                ],
                array_keys((new \Drupal\administerusersbyrole\AdministerusersbyrolePermissions($access_manager))->permissions())
            );
        }

        // Entity queue
        if ($this->moduleHandler->moduleExists('entityqueue')) {
            $permissions['general']['entityqueue'] = [
                'title' => $this->t('Entity Queue'),
                'id' => 'entityqueue',
                'permissions' => array_merge(
                    [
                        'manipulate all entityqueues',
                        'manipulate entityqueues',
                    ],
                    array_keys((new \Drupal\entityqueue\EntityQueuePermissions())->permissions())
                ),
            ];
        }

        // Form mode manager
        if ($this->moduleHandler->moduleExists('form_mode_manager')) {
            $form_mode_manager_permissions = FormModeManagerPermissions::create(\Drupal::getContainer());
            $permissions['general']['form_mode_manager'] = [
                'title' => $this->t('Form Mode Manager'),
                'id' => 'form_mode_manager',
                'permissions' => array_keys($form_mode_manager_permissions->formModeManagerPermissions()),
            ];
        }

        // Workbench
        if ($this->moduleHandler->moduleExists('workbench_access')) {
            $permissions['general']['workbench_access'] = [
                'title' => $this->t('Workbench Access'),
                'id' => 'workbench_access',
                'permissions' => [
                    'use workbench access',
                    'view workbench access information',
                    'assign workbench access',
                    'assign selected workbench access',
                    'bypass workbench access',
                    'batch update workbench access',
                ],
            ];
        }

        // Layout Builder
        if ($this->moduleHandler->moduleExists('layout_builder')) {
            $permissions['general']['layout_builder'] = [
                'title' => $this->t('Layout Builder'),
                'id' => 'layout_builder',
                'permissions' => array_merge(
                    [
                        'configure any layout',
                        'create and edit custom blocks',
                    ],
                    array_keys(\Drupal\layout_builder\LayoutBuilderOverridesPermissions::create(\Drupal::getContainer())->permissions())
                ),
            ];

            // Seeds Layouts
            if ($this->moduleHandler->moduleExists('seeds_layouts')) {
                $permissions['general']['layout_builder']['permissions'][] = 'access advanced seeds layouts settings';
            }
        }

        // Paragraphs
        if ($this->moduleHandler->moduleExists('paragraphs')) {
            $permissions['general']['paragraphs'] = [
                'title' => $this->t('Paragraphs'),
                'id' => 'paragraphs',
                'permissions' => [
                    'translate paragraph',
                    'view unpublished paragraphs',
                ],
            ];
        }

        // Filter.
        if ($this->moduleHandler->moduleExists('filter')) {
            $permissions['general']['filter'] = [
                'title' => $this->t('Filter'),
                'id' => 'filter',
                'permissions' => array_keys(\Drupal\filter\FilterPermissions::create(\Drupal::getContainer())->permissions()),
            ];
        }

        // Webform.
        if ($this->moduleHandler->moduleExists('webform')) {
            $permissions['general']['webform'] = [
                'title' => $this->t('Webform'),
                'id' => 'webform',
                'permissions' => [
                    'access webform overview',
                    'access webform submission user',
                    'view any webform submission',
                    'view own webform submission',
                    'edit any webform submission',
                    'edit own webform submission',
                ],
            ];
        }

        // Search
        if ($this->moduleHandler->moduleExists('search')) {
            $permissions['general']['search'] = [
                'title' => $this->t('Search'),
                'id' => 'search',
                'permissions' => [
                    'search content',
                    'use advanced search',
                ],
            ];
        }
        // Handle custom modules.
        $this->customModulesPermissions($permissions);

        // Provide an alter hook.
        $this->moduleHandler->alter('seeds_pollination_permissions', $permissions);

        return $permissions;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state, RoleInterface $user_role = NULL) {
        $this->userRole = $user_role;
        $form = parent::buildForm($form, $form_state);
        $role = $user_role;

        // Add a search input box.
        $form['search'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Search'),
        ];

        $form['permissions'] = [
            '#type' => 'container',
            '#tree' => TRUE,
            '#pre_render' => [[$this, 'preRender']],
        ];
        $modules = $this->getModulesPermissions();
        foreach ($modules as $group_id => $sections) {
            $module_name = $sections['title'];
            unset($sections['title']);

            $form['permissions']["{$group_id}_title"] = [
                '#type' => 'html_tag',
                '#tag' => 'h2',
                '#value' => $module_name,
            ];

            foreach ($sections as $section) {
                foreach ($section['permissions'] as $permission) {
                    $permission_title = $permission;
                    $form['permissions'][$permission] = [
                        '#type' => 'checkbox',
                        '#default_value' => $role->hasPermission($permission),
                        '#title' => $permission_title,
                        '#section' => $section['id'],
                        '#section_title' => $section['title'],
                        '#copy' => ($section['copy'] ?? FALSE),
                        '#permissions_group' => $group_id,
                        '#attributes' => [
                            'data-copy' => ($section['copy'] ?? FALSE),
                        ],
                    ];
                }

            }

        }

        return $form;
    }

    /**
     * Prerender the form.
     *
     * @param array $form
     * @return void
     */
    public function preRender($permissions) {
        $sections = [];
        $all_permissions = $this->permissionsHandler->getPermissions();
        foreach (Element::children($permissions) as $key) {
            $child = $permissions[$key];
            if (isset($child['#type']) && 'checkbox' == $child['#type']) {
                if (!isset($sections[$child['#section']])) {
                    $sections[$child['#section']] = [
                        '#theme' => 'permissions_section',
                        '#checked_count' => 0,
                        '#permissions_count' => 0,
                        '#attributes' => [
                            'data-group' => $child['#permissions_group'],
                        ],
                    ];
                }

                if (isset($all_permissions[$key])) {
                    $permission_title = $all_permissions[$key]['title'];

                    $child['#title'] = $permission_title;

                    // Check if it is restricted.
                    $restricted = $all_permissions[$key]['restrict access'] ?? FALSE;
                    if ($restricted) {
                        $child['#wrapper_attributes']['class'][] = 'danger';
                    }

                    // Get the description.
                    $description = $all_permissions[$key]['description'] ?? NULL;
                    // TODO: Use dependency injection.
                    $description = is_array($description) && Element::isVisibleElement($description) ? \Drupal::service('renderer')->render($description) : $description;
                    $child['#description'] = $description;

                    if (TRUE == $child['#value']) {
                        $sections[$child['#section']]['#checked_count'] += 1;
                    }
                    $sections[$child['#section']]['#permissions_count'] += 1;

                }

                $sections[$child['#section']]['#permissions'][] = $child;
                $sections[$child['#section']]['#copy'] = $child['#copy'];
                $sections[$child['#section']]['#section_name'] = $child['#section_title'];
            } else {
                $sections[$key] = $child;
            }

            unset($permissions[$key]);
        }

        $permissions = $permissions + $sections;
        $permissions['#attached']['library'] = ['seeds_pollination/permissions_sections'];
        return $permissions;
    }

    /**
     * {@inheritDoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $values = $form_state->getValues();
        user_role_change_permissions($this->userRole->id(), $values['permissions']);
        $this->messenger()->addStatus($this->t('The changes have been saved.'));
    }
}