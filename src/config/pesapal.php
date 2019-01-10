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
    | Pesapal Merchant Key
    |--------------------------------------------------------------------------
    |
    | The key obtained after creating your pesapal demo or live account
    |
    */
    'merchant_key' => env('PESAPAL_MERCHANT', ''),
    /*
   |--------------------------------------------------------------------------
   | Pesapal Merchant Secret
   |--------------------------------------------------------------------------
   |
   | The secret key obtained after creating your pesapal demo or live account
   |
   */
    'merchant_secret' => env('PESAPAL_SECRET', ''),
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
   | The page where you want your users to land making a transaction
   | Make sure you edit this value according to your project needs
   |
   */
    'callback_url' => 'https://www.yourSite.com/callback',

];