<?php

namespace Drupal\links_library\Plugin\Field\FieldFormatter;


use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'linksLibraryFormatter' formatter.
 *
 * @FieldFormatter(
 *   id = "linksLibraryFormatter",
 *   label = @Translation("Links Library Formatter"),
 *   description = @Translation("Links Library Formatter"),
 *   field_types = {
 *     "linksLibrary",
 *   }
 * )
 */
class linksLibraryFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    // Get current language code to get multilingual adimo widget.
    $elements = [];
    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#theme'            => 'librarylinks',
        '#linksFromLibrary' => $item->linksFromLibrary,
        '#libraryLinks'     => $item->libraryLinks,
        '#links'            => $item->links,
        '#linkTitle'        => $item->linkTitle,
      ];
    }
    return $elements;
  }

}
