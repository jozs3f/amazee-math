<?php

namespace Drupal\amazee_math\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the Lexer constraint.
 */
class LexerValidator extends ConstraintValidator {

  /**
   * Context variable.
   *
   * @var \Symfony\Component\Validator\Context\ExecutionContextInterface
   */
  protected $context;

  /**
   * {@inheritdoc}
   */
  public function validate($data, Constraint $constraint) {
    $item = $data->first();
    if(!isset($item)) {
      return NULL;
    }

    if(!preg_match('/^[\d +-\/*]*$/', $item->value)) {
      $this->context->addViolation($constraint->notValidData);
    }
  }

}
