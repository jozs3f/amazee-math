# Math Lexer & Parser

## Task

Create a simple (plus / minus / multiplication / division) mathematical Lexer &Parser service and make it available as a field formatter plugin in Drupal 8. Output this field to the Frontend.

  1. The Parser needs to be able to compute simple mathematical operationsusing the most basic operators (+, -, *, /) without using eval().for example: “10 + 20 - 30 + 15 * 5” should return 75.
  2. Make sure you take care of operator precedence using infix notation.
  3. Provide a field formatter plugin in a Drupal 8 module that uses this Service.
  4. Provide a simple unit test with a data provider (@dataProvider) thattests the tokenization (lexing) and parsing of a few different computations.
  5. Add a frontend component in a template language (Twig, React) ofyour choice that will animate the calculation in the frontend, i.e. you first show the entire formula and on-hover, the text transitions into thecomputed outcome.  

## Requirements
  - docker

## Usage
 - clone repository
 - add `amazee.local` and `phpmyadmin.local` to hosts
 - go into the amazee-math/docker directory and run `docker-compose up --build`
 - run composer install
 - access phpmyadmin.local and create a database
 - import attached db dump or install new site and import the config 

## Content
 - add a new `Lexer Parser` content and insert into the Data field an expression `ex. 10 + 20 - 30 + 15 * 5`, go to the view page and see the results
 - the lexer only works for int/float and +-/* operations
 
## Test
 - access the contain run `docker-compose exec php bash`
 - go in to the web directory `cd web` and write `phpunit` this takes the data from phpunit.xml and runs the modules tests
