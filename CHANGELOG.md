# Change Log

## [v2.1.0](https://github.com/bryceandy/laravel_pesapal/compare/v2.0.9...v2.1.0) - October 28, 2021
 * Add support for PHP 8

## [v2.0.9](https://github.com/bryceandy/laravel_pesapal/compare/v2.0.8...v2.0.9) - July 13, 2021
  * Bump [file system](https://github.com/thephpleague/flysystem) from 1.1.3 to 1.1.4
  * Update other dependencies

## [v2.0.8](https://github.com/bryceandy/laravel_pesapal/compare/v2.0.7...v2.0.8) - May 6, 2021
  * Add a custom message for ConfigurationUnavailableException
  * Throw ValidationException when validating request data
  * Minor fixes

## [v2.0.7](https://github.com/bryceandy/laravel_pesapal/compare/v2.0.6...v2.0.7) - April 26, 2021
  * Update [hamcrest](https://github.com/hamcrest/hamcrest-php) due to an issue with its generator
  * Bump [laravel](https://github.com/laravel/framework) from 7.16.1 to 7.30.*
  * Bump [symphony kernel](https://github.com/symphony/http-kernel) from 5.1.2 to 5.1.5
  * Update phpunit configuration to the latest valid schema

## [v2.0.6](https://github.com/bryceandy/laravel_pesapal/compare/v2.0.5...v2.0.6) - July 7, 2020  
  * Fix: enable iframe scrolling on smaller devices

## [v2.0.5](https://github.com/bryceandy/laravel_pesapal/compare/v2.0.4...v2.0.5) - July 6, 2020  
  * Fix: properly check request parameters that are missing 

## [v2.0.4](https://github.com/bryceandy/laravel_pesapal/compare/v2.0.3...v2.0.4) - July 5, 2020  
  * Add support to post payments with get requests  

## [v2.0.3](https://github.com/bryceandy/laravel_pesapal/compare/v2.0.2...v2.0.3) - June 18, 2020  
  * Parameterize post_xml variable 

## [v2.0.2](https://github.com/bryceandy/laravel_pesapal/compare/v2.0.1...v2.0.2) - June 18, 2020  
  * Create middleware to validate configurations 
  * Use request array to create post_xml  

## [v2.0.1](https://github.com/bryceandy/laravel_pesapal/compare/v2.0.0...v2.0.1) - June 18, 2020  
  * Add a route name for the route that posts payments
  * Remove csrf key in the array that saves a new payment  

## [v2.0.0](https://github.com/bryceandy/laravel_pesapal/compare/v2.0.0-beta.1...v2.0.0) - June 17, 2020  
  * Version 2 release  

## [v2.0.0-beta.1](https://github.com/bryceandy/laravel_pesapal/compare/v1.0.1...v2.0.0-beta.1) - June 17, 2020
  * Version support
    * PHP
      * The minimum PHP version required is from 7.4.*
    * Laravel
      * The minimum Laravel version supported is 7.*
  * Publishing files
    * This version would not allow publishing any views, migrations or assets
    * The only file that remains published will be the pesapal config file
  * New facade to enable the querying of a payment status and order details
  * Customizable IPN listener. When a payment status changes, you can choose whether to 
    * Send an e-mail or notification
    * Fire an event or dispatch a job

## [v1.0.1](https://github.com/bryceandy/laravel_pesapal/compare/v1.0.0...v1.0.1) - January 11, 2019
  * Remove default empty config values for consumer key and consumer secret
  * Add important comments

## v1.0.0 - January 10, 2019
  * Initial release