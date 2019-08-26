<?php

namespace Drupal\amazee_math\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Checks if field value contains only given types of characters.
 *
 * @Constraint(
 *   id = "Lexer",
 *   label = @Translation("Lexer", context = "Validation"),
 *   type = "string"
 * )
 */
class Lexer extends Constraint {

  public $notValidData = 'The data field can only contain numbers and +-*/ operators';

}
