<?php

namespace Drupal\seeds_development\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SeedsDevelopmentController.
 */
class SeedsDevelopmentController extends ControllerBase {

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The inspector
   *
   * @var \Drupal\seeds_development\SeedsDevelopmentInspectorInterface
   */
  protected $inspector;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->entityTypeManager = $container->get('entity_type.manager');
    $instance->inspector = $container->get('seeds_development.inspector');
    return $instance;
  }

  /**
   * Inspectimagestyle.
   *
   * @return string
   *   Return Hello string.
   */
  public function inspectImageStyle(\Drupal\image\ImageStyleInterface $image_style) {

    $sections = $this->inspector->imageStyleUseability($image_style);
    $elements = [];
    foreach ($sections as $section) {

      $children = [];

      foreach ($section['content'] as $child) {
        $children[] = [
          '#type' => 'container',
          'link' => [
            '#type' => 'link',
            '#url' => $child['url'],
            '#title' => $child['label'],
          ],
        ];
      }

      $elements[$section['id']] = [
        '#type' => 'fieldset',
        '#title' => $section['title'],
        'children' => $children,
      ];
    }

    return $elements;
  }

  public function generateFieldGroups($entity_type_id, $bundle, $form_mode) {
    $tabs = (object) [
      'group_name' => 'group_tabs',
      'entity_type' => $entity_type_id,
      'bundle' => $bundle,
      'mode' => $form_mode,
      'context' => 'form',
      'children' => ['group_basic_information', 'group_media'],
      'parent_name' => "",
      'weight' => 1,
      'format_type' => 'tabs',
      'label' => 'Tabs',
      'region' => 'content',
      'format_settings' => [
      ],
    ];

    $basic_information = (object) [
      'group_name' => 'group_basic_information',
      'entity_type' => $entity_type_id,
      'bundle' => $bundle,
      'mode' => $form_mode,
      'context' => 'form',
      'children' => ['langcode', 'description', 'body', 'field_body', 'field_text', 'field_text_1', 'field_link', 'field_taxonomy', 'field_taxonomy_1'],
      'parent_name' => "",
      'weight' => 1,
      'format_type' => 'tab',
      'label' => 'Basic Information',
      'region' => 'content',
      'format_settings' => [
        'label' => 'Basic Information',
        'id' => "",
        'classes' => '',
        'description' => '',
        'formatter' => 'closed',
        'required_fields' => 1,
      ],
    ];

    $media = (object) [
      'group_name' => 'group_media',
      'entity_type' => $entity_type_id,
      'bundle' => $bundle,
      'mode' => $form_mode,
      'context' => 'form',
      'children' => ['field_image', 'field_media', 'field_media_1'],
      'parent_name' => "",
      'weight' => 2,
      'format_type' => 'tab',
      'label' => 'Media',
      'region' => 'content',
      'format_settings' => [
        'label' => 'Media',
        'id' => "",
        'classes' => '',
        'description' => '',
        'formatter' => 'closed',
        'required_fields' => 1,
      ],
    ];

    field_group_group_save($tabs);
    field_group_group_save($basic_information);
    field_group_group_save($media);

    $this->messenger()->addStatus(t('Generated the field groups'));

    $definition = $this->entityTypeManager()->getDefinition($entity_type_id);

    return $this->redirect("entity.entity_form_display.$entity_type_id.default", [$definition->get('bundle_entity_type') => $bundle]);
  }

  /**
   * Viewdisplayinspect.
   *
   * @return string
   *   Return Hello string.
   */
  public function viewDisplayInspect($entity_type_id, $bundle, $view_mode) {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: viewDisplayInspect with parameter(s): $entity_type_id, $bundle, $view_mode'),
    ];
  }

}
