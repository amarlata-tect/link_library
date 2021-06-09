<?php

namespace Drupal\links_library\Plugin\Field\FieldWidget;

use Drupal\Core\Entity\Element\EntityAutocomplete;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Plugin implementation of the 'linksLibraryWidget' widget.
 *
 * @FieldWidget(
 *   id = "linksLibraryWidget",
 *   label = @Translation("Library Links - Widget"),
 *   description = @Translation("Library Links  - Widget"),
 *   field_types = {
 *     "linksLibrary",
 *   },
 *   multiple_values = TRUE,
 * )
 */
class linksLibraryWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    $linksFromLibrary = isset($items[$delta]->linksFromLibrary) ? $items[$delta]->linksFromLibrary : '';
    $title = isset($items[$delta]->linkTitle) ? $items[$delta]->linkTitle : NULL;
    $item = $items[$delta];

      $element['linksFromLibrary'] = [
      '#type'          => 'checkbox',
      '#title'         => $this->t('Links From Library'),
      '#default_value' => $linksFromLibrary,
      '#attributes' => [
        'id' => 'linksFromLibrary',
      ],

    ];
    $element['libraryLinks'] = [
      '#type'          => 'entity_autocomplete',
      '#target_type' => 'taxonomy_term',
      '#title'         => $this->t('library Links'),
      '#description'   => $this->t('Start typing the title of a piece of content to select it.
      You can add new link from <a href = "/admin/structure/taxonomy/manage/link_library/overview"
      target = "blank">here</a>.'),
      '#default_value' =>  (!is_null($item) && !empty($item->libraryLinks) && (\Drupal::currentUser()->hasPermission('link to any page') || $item->getUrl()->access())) ? static::getUriAsDisplayableStringValue('taxonomy_term', $item->libraryLinks, true) : NULL,
      '#selection_settings' => [
        'target_bundles' => ['link_library'],
      ],

      '#states' => [
        'visible' => [':input[id="linksFromLibrary"]' => ['checked' => TRUE]],
      ],
    ];

    $element['links'] = [
      '#type'          => 'entity_autocomplete',
      '#target_type' => 'node',
      '#title'         => $this->t('Link url'),
      '#description'   => $this->t('Start typing the title of a piece of content to select internal link.'),
      '#default_value' => (!is_null($item) && !empty($item->links) && (\Drupal::currentUser()->hasPermission('link to any page') || $item->getUrl()->access())) ? static::getUriAsDisplayableStringValue('node', $item->links) : NULL,
      '#process_default_value' => FALSE,
      '#states' => [
        'visible' => ['input[id="linksFromLibrary"]' =>  ['checked' => FALSE]],
      ],
    ];
    $element['linkTitle'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Link text'),
      '#default_value' => $title,
      '#maxlength' => 255,
      '#states' => [
        'visible' => ['input[id="linksFromLibrary"]' =>  ['checked' => FALSE]],
      ],
    ];

    return $element;
  }

  protected static function getUriAsDisplayableStringValue($entity_type, $entity_id, $object = false) {
    $entity = \Drupal::entityTypeManager()->getStorage($entity_type)->load($entity_id);
    if ($object) {
      return $entity;
    }
    return $displayable_string = EntityAutocomplete::getEntityLabels([$entity]);
  }
}
