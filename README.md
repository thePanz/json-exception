# JSON-Exception

[![Latest Version](https://img.shields.io/github/release/thePanz/json-exception.svg?style=flat-square)](https://github.com/thePanz/json-exception/releases)
[![Downloads](https://img.shields.io/packagist/dt/pnz/json-exception.svg)](https://packagist.org/packages/pnz/json-exception)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/thePanz/json-exception/master.svg?style=flat-square)](https://travis-ci.org/thePanz/json-exception)

## Usage

This library provides `Json::decode()` and `Json::encode()` implementations throwing `\JsonException` on errors.

To use this library:

- install the library by using composer: `composer require pnz/json-exception`
- replace the usage of `json_decode()` with `Json::decode()`
- replace the usage of `json_encode()` with `Json::encode()`
- catch the `\JsonException` eventually thrown by the functions

Example:
Old code
```php
 $data = json_decode($jsonString, ...);
 if (ERROR_NONE !== json_last_error()) {
     // handle the error: thown a custom exception, or return
     // $error = json_last_error_msg();
     // $errorCode = json_last_error();
 }
```

new code:
```php
try {
    $data = Json::decode($jsonString, ...);
} catch(\JsonException $e) {
   // Handle the exception
}
``` 

## Development

To run the PHP coding-styles checks (`php-cs-fixer` and `phpstan`) run the `make phpcs` command to:

- download the `php-cs-fixer` tool in `tools/` (if not present)
- download the `phpstan` tool in `tools/` (if not present)
- Run `php-cs-fixer` on the source code
- Run `phpstan` on the source code

To run the tests, use `make tests` to

- download `phpunit` tool in `tools/` if not present
- run `phpunit` tests
