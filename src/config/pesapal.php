<?php

return [

    /*
    |--------------------------------------------------------------------------
    | IPN Notifications Email
    |--------------------------------------------------------------------------
    |
    | This is the email through which Pesapal will send notifications indicating
    | whether payments are still pending, completed, invalid, or rather failed
    |
    */
    'send_ipn_notifications_to' => 'your@email.com',
    /*
    |--------------------------------------------------------------------------
    | Pesapal Consumer Key
    |--------------------------------------------------------------------------
    |
    | The key obtained after creating your pesapal demo or live account
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
   | The secret key obtained after creating your pesapal demo or live account
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
   | 'true' if your account was obtained from https://www.pesapal.com and
   | 'false' if your account was obtained from https://demo.pesapal.com
   |
   */
    'is_live' => '',
    /*
   |--------------------------------------------------------------------------
   | Callback URL
   |--------------------------------------------------------------------------
   |
   | The page where you want your users to land making a transaction. Make
   | sure you edit this value according to your project. Everything will
   | work correctly once you go live.
   |
   */
    'callback_url' => 'http://yourSite.com/callback',

];