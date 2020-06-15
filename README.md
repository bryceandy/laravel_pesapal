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
 
 
### Configuration  
 
Next we publish the configuration file that comes with the package  

```bash
php artisan vendor:publish pesapal-config
```  

After publishing, you will find a `pesapal.php` file in your `config` directory  

Head over to [demo](https://demo.pesapal.com) if you want a testing environment or [live](https://www.pesapal.com) for a live integration and create a business account. You will obtain a key-secret pair for your integration

![Pesapal Registration](images/register.png)   
 

Inside your `.env` file, create these environment variables and they will be used to set configuration values available in the published `config/pesapal.php` file  

Use the keys you obtained from Pesapal to fill the key and secret. If you are on a live account, set the **is_live** variable to true.  

```dotenv
PESPAL_KEY=yourConsumerKey
PESAPAL_SECRET=yourConsumerSecret
PESAPAL_IS_LIVE=false
PESAPAL_CALLBACK_URL=
PESAPAL_IPN_EMAIL=
```  

The last two variables will be handled later.  

There after run the migration command as the package will load a database migration that stores the payment records    

```bash
php artisan migrate
```  


### Usage  
  
1. Making a request to Pesapal for a payment


### IMPORTANT  

Especially for live accounts, on your pesapal dashboard find your Account Settings and click IPN Settings.  
 
Fill in your website domain for example `yourWebsite.co.tz` and IPN listener URL as `yourWebsite.co.tz/pesapal-ipn-listener`.  

This is with the assumption you created a web route with a GET request to  `/pesapal-ipn-listener`  

**Go ahead and start making payments!**.   


### License   

MIT License.


### Contributors  

The base of this package is from the PHP API of [Pesapal](https://pesapal.com)  
  
  - [BryceAndy](http://bryceandy.com) > hello@bryceandy.com  
  - Feel free to create pull requests and contribute to this package