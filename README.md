# This is fork package CallMeNP/lara-auth-bridge for Laravel 5.4 and phpBB 3.2

For phpBB < 3.2 see [CallMeNP/lara-auth-bridge](https://github.com/CallMeNP/lara-auth-bridge) Offers a simple API for the included custom phpBB authentication module for phpBB(3.0, 3.1) and Laravel 5.

[![Latest Stable Version](https://poser.pugx.org/tohtamysh/laravel-phpbb-bridge/v/stable)](https://packagist.org/packages/tohtamysh/laravel-phpbb-bridge) [![License](https://poser.pugx.org/tohtamysh/laravel-phpbb-bridge/license)](https://packagist.org/packages/tohtamysh/laravel-phpbb-bridge)

### Installation
#### Laravel
##### run composer
``` php
composer require tohtamysh/laravel-phpbb-bridge
```
##### add service provider
Register the Service Provider by adding it to your project's providers array in app.php
``` php
'providers' => array(
    Tohtamysh\LaravelPhpbbBridge\LaravelPhpbbBridgeServiceProvider::class,
);
```
##### publish config file
``` php
artisan vendor:publish --provider="Tohtamysh\LaravelPhpbbBridge\LaravelPhpbbBridgeServiceProvider"
```
##### edit config
Change configs config/laravel-phpbb-bridge.php
``` php
// Create a secret app key in 
'appkey' => 'yoursecretapikey'

// Update the column names used for the Laravel Auth driver 
'username_column' => 'user_login',
'password_column' => 'user_password'

// Set true if you use multiAuth, false if default Laravel Auth
'client_auth' => false
```
##### exclude URIs from CSRF protection
In file app/Http/Middleware/VerifyCsrfToken.php add
``` php
protected $except = [
        	'auth-bridge/*',
    	];
```
More info how to exclude uris on [laravel site](http://laravel.com/docs/master/routing#csrf-excluding-uris)

#### phpBB 3.2
##### copy files 
Copy all files in the phpBB32 directory to your phpBB install folder
##### edit config
Edit the file located at {PHPBB-ROOT}/ext/laravel/bridgebb/auth/provider/bridgebb.php
``` php
define('LARAVEL_URL', 'http://www.example.com'); //your laravel application's url
define('BRIDGEBB_API_KEY', "yoursecretapikey"); //the same key you created earlier
define ('LARAVEL_CUSTOM_USER_DATA', serialize ([
    'email' => 'user_email',
    'dob' => 'user_birthday',
])); // Update the columns you want to come from Laravel user to phpBB user
```
###### setting
Login to the phpBB admin panel enable bridgebb extension and after set bridgebb as the authentication module
