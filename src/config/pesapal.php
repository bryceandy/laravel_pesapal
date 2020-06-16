<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pesapal Consumer Key
    |--------------------------------------------------------------------------
    |
    | The key obtained after creating your PesaPal demo or live account
    | When committing this to a repository, remove the default value
    | and put it into your online PESAPAL_KEY config variable
    |
    */
    'consumer_key' => env('PESAPAL_KEY'),

    /*
   |--------------------------------------------------------------------------
   | Pesapal Consumer Secret
   |--------------------------------------------------------------------------
   |
   | The secret key obtained after creating your PesaPal demo or live account
   | When committing this to a repository, remove the default value and
   | put it into your online PESAPAL_SECRET configuration variable
   |
   */
    'consumer_secret' => env('PESAPAL_SECRET'),

    /*
   |--------------------------------------------------------------------------
   | Pesapal Account Type
   |--------------------------------------------------------------------------
   |
   | true if your account was obtained from https://www.pesapal.com and
   | false if your account was obtained from https://demo.pesapal.com
   |
   */
    'is_live' => env('PESAPAL_IS_LIVE', false),

    /*
   |--------------------------------------------------------------------------
   | Callback URL
   |--------------------------------------------------------------------------
   |
   | This is the full url pointing to the page that the iframe
   | redirects to after processing the order on pesapal.com
   |
   */
    'callback_url' => env('PESAPAL_CALLBACK_URL'),
];
