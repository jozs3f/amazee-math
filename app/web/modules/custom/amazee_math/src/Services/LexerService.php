<?php

namespace Drupal\amazee_math\Services;

/**
 * Class LexerService.
 */
class LexerService {

  protected static $patterns = [
    [
      'type' => 'number',
      'pattern' => '/^\d+(\.\d+)?/',
      'order' => 0
    ],
    [
      'type' => 'operation_add',
      'pattern' => '/^\+/',
      'order' => 1
    ],
    [
      'type' => 'operation_sub',
      'pattern' => '/^\-/',
      'order' => 1
    ],
    [
      'type' => 'operation_div',
      'pattern' => '/^\//',
      'order' => 2
    ],
    [
      'type' => 'operation_multiply',
      'pattern' => '/^\*/',
      'order' => 2
    ]
  ];

  /**
   * Tokenize the a mathematical expression.
   * 
   * @param string $expression
   *   A mathematical expression.
   * 
   * @return array
   *   Return an array containing the tokens.
   */
  public function tokenize($expression) {
    $tokens = [];
    $offset  = 0;

    while ($offset  < strlen($expression)) {
      if (preg_match('/^\s/', substr($expression, $offset))) {
        $offset += 1;
        continue;
      }
      
      $result = $this->match(substr($expression, $offset));
      if (!empty($result)) {
        $tokens[] = [
          'type' => $result['type'],
          'value' => $result['value'],
          'order' => $result['order']
        ];
        $offset += strlen($result['value']);
      } else {
        $offset += 1;
      }
    }

    return $tokens;
  }

  /**
   * Match the value to on of the patterns.
   * 
   * @param string $value
   *   Current value of the expressio.
   * 
   * @return array
   *   Return empty array or matched value containing type/value/order of the pattern.
   */
  public function match($value) {
    $results = [];
    foreach (self::$patterns as $pattern) {
      $found = preg_match($pattern['pattern'], $value, $matches);
      if ($found) {
        $results = [
          'type' => $pattern['type'],
          'value' => $matches[0],
          'order' => $pattern['order'],
        ];
      }
    }

    return $results;
  }
}