<?php

namespace Drupal\seeds_pollination\Routing;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RouteSubscriber.
 *
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a new 'RouteSubscriber' object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    // Replace the core permissions form for a role with seeds pollination.
    if ($this->configFactory->get('seeds_pollination.settings')->get('replace_permissions_form_route')) {
      if ($route = $collection->get('entity.user_role.edit_permissions_form')) {
        $route->setDefault('_form', '\Drupal\seeds_pollination\Form\SeedsPollinationPermissionsForm');
        $route->setRequirements([
          '_entity_access' => 'user_role.update',
        ]);
      }
    }
  }

}
