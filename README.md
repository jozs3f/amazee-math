# Math Lexer & Parser

## Requirements
  - docker

## Usage
 - clone repository
 - add `amazee.local` and `phpmyadmin.local` to hosts
 - go into the amazee-math/docker directory and run `docker-compose up --build`
 - access phpmyadmin.local and create a database
 - create 

## Content
 - add a new `Lexer Parser` content and insert into the Data field an expression `ex. 10 + 20 - 30 + 15 * 5`, go to the view page and see the results
 
## Test
 - access the contain run `docker-compose exec php bash`
 - go in to the web directory `cd web` and write `phpunit`
