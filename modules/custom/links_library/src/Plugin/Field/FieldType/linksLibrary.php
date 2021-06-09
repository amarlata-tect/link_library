<?php

namespace Drupal\links_library\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'linksLibrary' field type.
 *
 * @FieldType(
 *   id = "linksLibrary",
 *   label = @Translation("Library Links"),
 *   module = "links_library",
 *   category = @Translation("Links"),
 *   description = @Translation("Adds a Link service to a web page."),
 *   default_widget = "linksLibraryWidget",
 *   default_formatter = "linksLibraryFormatter"
 * )
 */
class linksLibrary extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {

    return [
      'columns' => [
        'linksFromLibrary'  => [
          'description' => 'Boolean value for condition.',
          'type'        => 'text',
        ],
        'libraryLinks'     => [
          'description' => 'taxonomy reference field value.',
          'type'        => 'varchar',
          'length' => 2048,
        ],
        'links'        => [
          'description' => 'internal and external links.',
          'type' => 'varchar',
          'length' => 2048,
        ],
        'linkTitle' => [
          'description' => 'The link text.',
          'type' => 'varchar',
          'length' => 255,
        ],
      ],
    ];
  }


  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['linksFromLibrary'] = DataDefinition::create('string')
      ->setLabel(t('linksFromLibrary'));

    $properties['libraryLinks'] = DataDefinition::create('string')
      ->setLabel(t('libraryLinks'));

    $properties['links'] = DataDefinition::create('string')
      ->setLabel(t('links'));

    $properties['linkTitle'] = DataDefinition::create('string')
      ->setLabel(t('linkTitle'));

    return $properties;
  }

}
