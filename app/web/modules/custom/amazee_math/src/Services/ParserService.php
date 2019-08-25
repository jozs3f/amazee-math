<?php

namespace Drupal\amazee_math\Services;


/**
 * Class ParserService.
 */
class ParserService {

  /**
   * Parse an array and run the mathematical expressions.
   * 
   * @params array $tokens
   *   Contains the lexed tokens.
   * 
   * @return string
   *   Return the mathematical expression value.
   */
  public function parse($tokens) {

    $values = [];
    $ops = [];

    while(count($tokens) >= 1) {
      $token = array_shift($tokens);
      if ($token['type'] === 'number') {
        $values[] = $token['value'];
      }
      else if (preg_match('/^operation/', $token['type'])) {
        if ($token['order'] === 1) {
          $ops[] = $token['type'];
        }
        else if ($token['order'] === 2) {
          $first = reset($tokens);
          $a = array_pop($values);
          $b = $first['value'];
  
          $values[] = $this->applyOperations(floatval($a), floatval($b), $token['type']);
          array_shift($tokens);
        }
      }
    }

    while(count($ops) >= 1) {
      $op = array_shift($ops);
      $a = array_shift($values);
      $b = array_shift($values);

      array_unshift($values, $this->applyOperations(floatval($a), floatval($b), $op));
    }

    $value = reset($values);

    return $value;
  }

  /**
   * Apply operation by operation type
   * 
   * @param float $a
   *   The first value in the stack.
   * @param float $b
   *   The second value in the stack.
   * @param string $op
   *   The operation type.
   * 
   * @return float
   *   Return the value.
   */
  protected function applyOperations($a, $b, $op){ 
    switch($op){ 
        case 'operation_add':
          return $a + $b;
        case 'operation_sub':
          return $a - $b;
        case 'operation_multiply':
          return $a * $b;
        case 'operation_div':
          return $a / $b;
    }
  } 
}