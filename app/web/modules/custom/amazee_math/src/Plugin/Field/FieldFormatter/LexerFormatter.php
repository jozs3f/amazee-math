<?php

namespace Drupal\amazee_math\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\amazee_math\Services\ParserService;
use Drupal\amazee_math\Services\LexerService;

/**
 * Plugin implementation of the 'amazee_lexer' formatter.
 *
 * @FieldFormatter(
 *   id = "amazee_lexer",
 *   label = @Translation("Amazee lexer&parser"),
 *   field_types = {
 *     "string"
 *   }
 * )
 */
class LexerFormatter extends FormatterBase implements ContainerFactoryPluginInterface {
  
  /**
   * @var \Drupal\amazee_math\Service\LexerService
   */
  protected $lexerService;

  /**
   * @var \Drupal\amazee_math\Service\ParserService
   */
  protected $parserService;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('amazee_math.lexer'),
      $container->get('amazee_math.parser')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, LexerService $lexer_service, ParserService $parser_service) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->lexerService = $lexer_service;
    $this->parserService = $parser_service;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Displays the mathematical lexer');
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    foreach ($items as $delta => $item) {
      $tokens = $this->lexerService->tokenize($item->value);
      $value = $this->parserService->parse($tokens);
      $element[$delta] = ['#markup' => 
        "
          <div class='math-result-container'>
            <div id='simple-output'>
              <p>Expression: $item->value</p>
              <p>Value: $value</p>
            </div>
            <div id='react-output'>
            </div>
          </div>
          "
      ];
      $element[$delta]['#attached']['library'][] = 'amazee_math/react';
      $element[$delta]['#attached']['library'][] = 'amazee_math/amazee_math.react';
      $element[$delta]['#attached']['drupalSettings']['amazee_math'] = [
        'expression' => $item->value,
        'value' => $value
      ];
      $element[$delta]['#cache']['max-age'] = 0;
    }

    return $element;
  }

}