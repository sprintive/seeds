<?php

namespace Drupal\seeds_development;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Url;
use Drupal\image\ImageStyleInterface;

/**
 * Class SeedsDevelopmentInspector.
 */
class SeedsDevelopmentInspector implements SeedsDevelopmentInspectorInterface {

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The module handler.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Constructs a new SeedsDevelopmentInspector object.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, ConfigFactoryInterface $config_factory, ModuleHandlerInterface $module_handler) {
    $this->entityTypeManager = $entity_type_manager;
    $this->configFactory = $config_factory;
    $this->moduleHandler = $module_handler;
  }

  /**
   *
   */
  private function configUsability($search) {
    $found = [];
    $config = shell_exec("grep '\(\:$search\:\)\|\(\W$search$\)' /var/www/html/oxford-jo/public_html/sites/default/config/* -lr");
    $config_list = explode(PHP_EOL, $config);
    foreach ($config_list as $path) {
      if ($config !== "") {
        $name = end(explode('/', $path));
        $found[] = [
          'id' => $name,
          'label' => $name,
          'url' => new Url('<none>'),
        ];
      }
    }

    return $found;
  }

  /**
   * {@inheritDoc}
   */
  public function imageStyleUseability(ImageStyleInterface $image_style) {
    // Get responsive images.
    $sections = [];
    if ($this->moduleHandler->moduleExists('responsive_image')) {
      $responsive_images = $this->entityTypeManager->getStorage('responsive_image_style')->loadMultiple();
      $responsive_images = array_filter($responsive_images, function ($responsive_image) use ($image_style) {
        /** @var \Drupal\responsive_image\ResponsiveImageStyleInterface $responsive_image */
        $mappings = $responsive_image->getImageStyleMappings();

        foreach ($mappings as $mapping) {
          if ($mapping['image_mapping'] == $image_style->id()) {
            return TRUE;
          }
        }

        if ($responsive_image->getFallbackImageStyle() == $image_style->id()) {
          return TRUE;
        }

        return FALSE;

      });

      $responsive_images = array_map(function ($responsive_image) {
        return [
          'label' => $responsive_image->label(),
          'id' => $responsive_image->id(),
          'url' => $responsive_image->toUrl('edit-form'),
        ];
      }, $responsive_images);

      $sections[] = [
        'id' => 'responsive_images',
        'title' => t('Responsive Images'),
        'content' => $responsive_images,
      ];
    }

    // View displays.
    /** @var \Drupal\Core\Entity\Entity\EntityViewDisplay[] */
    $view_displays = $this->entityTypeManager->getStorage('entity_view_display')->loadMultiple();
    $found_view_displays = [];
    foreach ($view_displays as $view_display) {
      $components = $view_display->getComponents();
      if (!$view_display->get('status')) {
        continue;
      }
      foreach ($components as $component) {
        if ($component['type'] == 'image' && $component['settings']['image_style'] == $image_style->id()) {
          $target_entity_type = $this->entityTypeManager->getDefinition($view_display->getTargetEntityTypeId());
          $view_mode = $view_display->get('mode');
          $url = NULL;
          if ($view_mode == 'default') {
            $url = new Url("entity.entity_view_display.{$target_entity_type->id()}.default", [
              $target_entity_type->getBundleEntityType() => $view_display->get('bundle'),
            ]);
          }
          else {
            $url = new Url("entity.entity_view_display.{$target_entity_type->id()}.view_mode",
              [
                'view_mode_name' => $view_mode,
                $target_entity_type->getBundleEntityType() => $view_display->get('bundle'),
              ]);
          }

          $found_view_displays[] = [
            'label' => "{$view_display->id()} ({$target_entity_type->getLabel()})",
            'id' => $view_display->id(),
            'url' => $url,
          ];
        }
      }

      if (!empty($found_view_displays)) {
        $sections[] = [
          'id' => 'view_displays',
          'title' => t('View Displays'),
          'content' => $found_view_displays,
        ];
      }

    }

    $found = $this->configUsability($image_style->id());
    if (!empty($found)) {
      $sections[] = [
        'id' => 'config',
        'title' => t("Found in Config"),
        'content' => $found,
      ];
    }

    return $sections;
  }

}
