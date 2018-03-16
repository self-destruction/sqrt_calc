# symfony-calculator
A calculator based on Symfony 4.1

## Introduction
A simple application with only one controller / 2 routes.
One route presents the form with no result, the redirects the user with an equation in post to the resultAction() with the equation in the url.

## Getting Up and running

- Clone me!
- `composer install`
- `php bin/console server:run`

### Todo/ideas
- Store each equation in order to present a list of history to the user (Txt file log, elastic search, local browser storage)
- Improve the security check on getResult() [Calculator/Calculator.php:35]
- Build an API Controller so the frontend can simply post the equation and get a json reponse containing the result
- Build an ajax call to API controller on the frontend
