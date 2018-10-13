<?php

namespace Drupal\seeds_media\Plugin\entity_embed\EntityEmbedDisplay;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Form\FormStateInterface;
use Drupal\entity_embed\Plugin\entity_embed\EntityEmbedDisplay\ImageFieldFormatter;
use Drupal\image\Plugin\Field\FieldType\ImageItem;
use Drupal\seeds_media\MediaHelper;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Entity\Element\EntityAutocomplete;
use Drupal\Component\Utility\Html;

/**
 * Renders a media item's image via the image formatter.
 *
 * If the embedded media item has an image field as its source field, that image
 * is rendered through the image formatter. Otherwise, the media item's
 * thumbnail is used.
 *
 * @EntityEmbedDisplay(
 *   id = "media_image",
 *   label = @Translation("Media Image"),
 *   entity_types = {"media"},
 *   field_type = "image",
 *   provider = "image"
 * )
 */
class MediaImage extends ImageFieldFormatter {

  /**
   * {@inheritdoc}
   */
  public function getFieldFormatterId() {
    return 'image';
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);
    $seeds_media_settings = \Drupal::config('seeds_media.settings');
    $allowed_images_styles = $seeds_media_settings->get('embed.allowed_image_styles');
    // Entity element is calculated on every AJAX request/submit. See ::buildForm().
    $entity_element = $form_state->get('entity_element');
    /** @var \Drupal\embed\EmbedButtonInterface $embed_button */
    $embed_button = $form_state->get('embed_button');
    /** @var \Drupal\editor\EditorInterface $editor */
    $editor = $form_state->get('editor');
    /** @var \Drupal\Core\Entity\EntityInterface $entity */
    $entity = $form_state->get('entity');
    $values = $form_state->getValues();

    if (is_string($entity_element['data-entity-embed-display-settings'])) {
      $entity_element['data-entity-embed-display-settings'] = Json::decode($entity_element['data-entity-embed-display-settings']);
    }

    // Don't allow linking directly to the content.
    unset($form['image_link']['#options']['content']);

    if (sizeof($allowed_images_styles) && isset($form['image_style'])) {
      $options = $form['image_style']['#options'];
      foreach ($options as $machine_name => $val) {
        if (!$allowed_images_styles[$machine_name]) {
          unset($form['image_style']['#options'][$machine_name]);
        }
      }
    }

    // Supress Drupal's "Link image to" dropdown when embedding an image,
    // since the 'Link to' option provides this functionality.
    if (isset($form['image_link'])) {
      $form['image_link']['#type'] = 'hidden';
      $form['image_link']['#value'] = '';
    }
    $form['link_url'] = [
      '#title' => t('Link to'),
      '#type' => 'entity_autocomplete',
      '#target_type' => 'node',
      '#attributes' => [
        'data-autocomplete-first-character-blacklist' => '/#?',
      ],
      '#element_validate' => [[get_called_class(), 'validateUriElement']],
      '#process_default_value' => FALSE,
      '#description' => $this->t('Start typing the title of a piece of content to select it. You can also enter an internal path such as %add-node or an external URL such as %url. Enter %front to link to the front page.', ['%front' => '<front>', '%add-node' => '/node/add', '%url' => 'http://example.com']),
      '#default_value' => isset($entity_element['data-entity-embed-display-settings']['link_url']) ? $this->getUriAsDisplayableString($entity_element['data-entity-embed-display-settings']['link_url']) : '',
      '#maxlength' => 2048,
    ];
    $form['link_url_target'] = [
      '#title' => t('Open in a new window?'),
      '#type' => 'checkbox',
      '#default_value' => isset($entity_element['data-entity-embed-display-settings']['link_url_target']) ? Html::decodeEntities($entity_element['data-entity-embed-display-settings']['link_url_target']) : '',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function getAttributeValues() {
    $field = $this->getItem();
    $label = $field->getEntity()->label();

    // Try to default to the alt and title attributes set on the field item, but
    // fall back to the entity label for both.
    return parent::getAttributeValues() + [
      'alt' =>
      $field->alt ?: $label,
      'title' =>
      $field->title ?: $label,
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function isValidImage() {
    // This display plugin works for any media entity. And media items always
    // have at least a thumbnail. So, we can bypass this access gate.
    return AccessResult::allowed();
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldDefinition() {
    // The parent method will set the target_type to the entity type being
    // embedded, but we are actually rendering an image (i.e., a file entity).
    return parent::getFieldDefinition()->setSetting('target_type', 'file');
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldValue() {
    $value = parent::getFieldValue();

    $value['target_id'] = $this->getItem()->target_id;

    return $value;
  }

  /**
   * Returns the image field item to use for the embedded entity.
   *
   * @return \Drupal\image\Plugin\Field\FieldType\ImageItem
   *   The image field item.
   */
  protected function getItem() {
    /** @var \Drupal\media\MediaInterface $entity */
    $entity = $this->getEntityFromContext();

    $item = MediaHelper::getSourceField($entity)->first();

    return $item instanceof ImageItem ? $item : $entity->get('thumbnail')->first();
  }

  /**
   * Gets the URI without the 'internal:' or 'entity:' scheme.
   *
   * The following two forms of URIs are transformed:
   * - 'entity:' URIs: to entity autocomplete ("label (entity id)") strings;
   * - 'internal:' URIs: the scheme is stripped.
   *
   * This method is the inverse of ::getUserEnteredStringAsUri().
   *
   * @param string $uri
   *   The URI to get the displayable string for.
   *
   * @return string
   *
   * @see static::getUserEnteredStringAsUri()
   */
  protected function getUriAsDisplayableString($uri) {
    $uri = Html::decodeEntities($uri);
    $scheme = parse_url($uri, PHP_URL_SCHEME);

    // By default, the displayable string is the URI.
    $displayable_string = $uri;

    // A different displayable string may be chosen in case of the 'internal:'
    // or 'entity:' built-in schemes.
    if ($scheme === 'internal') {
      $uri_reference = explode(':', $uri, 2)[1];

      // @todo '<front>' is valid input for BC reasons, may be removed by
      //   https://www.drupal.org/node/2421941
      $path = parse_url($uri, PHP_URL_PATH);
      if ($path === '/') {
        $uri_reference = '<front>' . substr($uri_reference, 1);
      }

      $displayable_string = $uri_reference;
    }
    elseif ($scheme === 'entity') {
      list($entity_type, $entity_id) = explode('/', substr($uri, 7), 2);
      // Show the 'entity:' URI as the entity autocomplete would.
      // @todo Support entity types other than 'node'. Will be fixed in
      //   https://www.drupal.org/node/2423093.
      if ($entity_type == 'node' && $entity = \Drupal::entityTypeManager()->getStorage($entity_type)->load($entity_id)) {
        $displayable_string = EntityAutocomplete::getEntityLabels([$entity]);
      }
    }

    return $displayable_string;
  }

  /**
   * Gets the user-entered string as a URI.
   *
   * The following two forms of input are mapped to URIs:
   * - entity autocomplete ("label (entity id)") strings: to 'entity:' URIs;
   * - strings without a detectable scheme: to 'internal:' URIs.
   *
   * This method is the inverse of ::getUriAsDisplayableString().
   *
   * @param string $string
   *   The user-entered string.
   *
   * @return string
   *   The URI, if a non-empty $uri was passed.
   *
   * @see static::getUriAsDisplayableString()
   */
  protected static function getUserEnteredStringAsUri($string) {
    // By default, assume the entered string is an URI.
    $uri = $string;
    // Detect entity autocomplete string, map to 'entity:' URI.
    $entity_id = EntityAutocomplete::extractEntityIdFromAutocompleteInput($string);
    if ($entity_id !== NULL) {
      // @todo Support entity types other than 'node'. Will be fixed in
      //   https://www.drupal.org/node/2423093.
      $uri = 'entity:node/' . $entity_id;
    }
    // Detect a schemeless string, map to 'internal:' URI.
    elseif (!empty($string) && parse_url($string, PHP_URL_SCHEME) === NULL) {
      // @todo '<front>' is valid input for BC reasons, may be removed by
      //   https://www.drupal.org/node/2421941
      // - '<front>' -> '/'
      // - '<front>#foo' -> '/#foo'
      if (strpos($string, '<front>') === 0) {
        $string = '/' . substr($string, strlen('<front>'));
      }
      $uri = 'internal:' . $string;
    }

    return $uri;
  }

  /**
   * Form element validation handler for the 'uri' element.
   *
   * Disallows saving inaccessible or untrusted URLs.
   */
  public static function validateUriElement($element, FormStateInterface $form_state, $form) {
    $uri = static::getUserEnteredStringAsUri($element['#value']);
    $form_state->setValueForElement($element, $uri);
    // If getUserEnteredStringAsUri() mapped the entered value to a 'internal:'
    // URI , ensure the raw value begins with '/', '?' or '#'.
    // @todo '<front>' is valid input for BC reasons, may be removed by
    //   https://www.drupal.org/node/2421941
    if (parse_url($uri, PHP_URL_SCHEME) === 'internal' && !in_array($element['#value'][0], ['/', '?', '#'], TRUE) && substr($element['#value'], 0, 7) !== '<front>') {
      $form_state->setError($element, t('Manually entered paths should start with /, ? or #.'));
      return;
    }
  }

}
