<?php

namespace Drupal\Tests\amazee_math\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\amazee_math\Services\LexerService;
use Drupal\amazee_math\Services\ParserService;

/**
 * Tests Math Lexer and Parser functionalities
 */
class LexerParserTest extends UnitTestCase {

  /**
   * @var \Drupal\amazee_math\Services\LexerService
   */
  protected $lexer;

  /**
   * @var \Drupal\amazee_math\Services\ParserService
   */
  protected $parser;

  /**
   * Setting up the test.
   */
  public function setUp(){
    $this->lexer = new LexerService();
    $this->parser = new ParserService();
  }

  /**
   * @dataProvider provider
   */
  public function testMathService($expression, $result) {
    $tokens = $this->lexer->tokenize($expression);
    $value = $this->parser->parse($tokens);  
    $this->assertEquals($value, $result);
  }

  /**
   * Data provider for testMathService().
   * 
   * @return array
   *    - $expression
   *    - $result
   */
  public function provider() {
    return [
        ['10 + 20 - 30 + 15 * 5', 75],
        ['10 / 20 - 30 * 15 + 5', -444.5],
        ['5 * 5 / 10 + 30 * 2', 62.5],
        ['5*5/10+30*2', 62.5]
    ];
  }
}
