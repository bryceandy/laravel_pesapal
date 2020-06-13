# Pesapal package for Laravel apps  

[![Actions Status](https://github.com/bryceandy/laravel_pesapal/workflows/Tests/badge.svg)](https://github.com/bryceandy/laravel_pesapal/actions) 
<a href="https://packagist.org/packages/bryceandy/laravel_pesapal"><img src="https://poser.pugx.org/bryceandy/laravel_pesapal/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/bryceandy/laravel_pesapal"><img src="https://poser.pugx.org/bryceandy/laravel_pesapal/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/bryceandy/laravel_pesapal"><img src="https://poser.pugx.org/bryceandy/laravel_pesapal/license.svg" alt="License"></a>  

![Pesapal iFrame](images/iFrame.png)  

This package enables Laravel developers to easily make use of the [Pesapal](https://www.pesapal.com) API. There are M-Pesa, Tigo pesa payments popular with East African mobile money systems. Other payment integrations include, but not limited to:  

  - Mastercard  
  - Visa  
  - American Express  

### Version support   

| Laravel version | Package version | Maintenance |
| --- | --- | --- |
| 5.7 - 6 | 1.0.0 - 1.0.1 | No longer maintained |
| 7 and above | 2.0.0 | Actively maintained |  

### Installation  

Pre-installation requirements  

  - A running  or newly installed Laravel 7.* or above  
  - PHP 7.4 or above  
  - cURL extension installed  

Now run the command...  

```bash
composer require bryceandy/laravel_pesapal
```  

### Files and Configuration  

Next we publish files using a service provider in our project using the command  

```bash
php artisan vendor:publish --provider="Bryceandy\Laravel_Pesapal\PesapalServiceProvider"
```  

After it runs successfully, you must see the following:  

  - A controller `TransactionController.php` inside 'app/Http/Controllers'  
  - A new model `app/Transaction.php`  
  - A migration to create the Transactions table under 'database/migrations/'. In order for this to work according to the setup, your Users table needs to have at least `first_name`, `last_name`, `email` fields, also password in the migrations set to `nullable()`. Lastly in the Users model, add the previous 3 fields inside the `$fillable` array, but since you have all these migrations and models you can modify them per your needs.  
  - New routes listed under 'resources/views/pesapal'. The views available are `details.blade.php`, `iframe.blade.php` and `callback_example.blade.php`  
  - A configuration file 'config/pesapal.php' and lastly  
  - A pesapal directory in the root 'public/' which should not be modified.  
  
Now after modifying the models, migrations and controller if need be then it is necessary to migrate normally using  

```bash
php artisan migrate
```  

#### Routes  
 
##### N B: You are not supposed to create any of these roots as they are configured for you.  

  - The `details.blade.php` view will display payment details where the user will put their details. Its route is a GET request to yourSite.com/details  

  - The `iframe.blade.php` view will display payment options as seen in the first image above. Its route is a POST request to yourSite.com/iframe  

  - The `callback_example.blade.php` is the view your users will land to after making a payment, it will also show the payment status for every transaction. Its route is a GET request to yourSite.com/callback  

Head over to [demo](https://demo.pesapal.com) if you want a testing environment or [live](https://www.pesapal.com) for a live integration and create a business account. You will obtain a key-secret pair for your integration  

![Pesapal Registration](images/register.png)  

#### Configurations  

Head over your project and create environment variables inside your `.env` such as  

```dotenv
PESPAL_KEY=yourConsumerKey
PESAPAL_SECRET=yourConsumerSecret
PESAPAL_IS_LIVE=false
PESAPAL_CALLBACK_URL=http://yourSite.com/callback
PESAPAL_IPN_EMAIL=emailReceivingIpnNotifications
```  

Modify the env variable and set `PESAPAL_IS_LIVE` to true if you have a live account, false is the default.  

Add your callback URL `PESPAL_CALLBACK_URL`, lastly set `PESAPAL_IPN_EMAIL` to the email you wish to receive IPN notifications.  


###### IMPORTANT  

Especially for live accounts, on your pesapal dashboard find your Account Settings and click IPN Settings. Fill in your website domain i.e `yourWebsite.co.tz` and IPN listener URL as `yourWebsite.co.tz/pesapal/ipn.php`, whatever your website name is just add '/pesapal/ipn.php' infront of it.   

**Go ahead and start making payments!**. Visit **YourSite'sDomain/details**  

i.e localhost/details or myAwesomeWebsite.com/details  

## License   

MIT  

## Contributors  

The base of this package is from the PHP API of [Pesapal](https://pesapal.com)  
  - [BryceAndy](http://bryceandy.com) > hello@bryceandy.com  
  - Feel free to create pull requests and contribute on this package  

**Free Software, Hell Yeah!**  