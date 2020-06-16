# Change Log

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