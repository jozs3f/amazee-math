# Math Lexer & Parser

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
