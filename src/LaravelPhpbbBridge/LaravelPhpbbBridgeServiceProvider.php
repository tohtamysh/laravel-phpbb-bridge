<?php

namespace Tohtamysh\LaravelPhpbbBridge;

use Illuminate\Support\ServiceProvider;
use Route;

class LaravelPhpbbBridgeServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('laravel-phpbb-bridge.php'),
        ], 'config');

        Route::group(['middleware' => ['web']], function () {
            Route::get('/auth-bridge/login', 'Tohtamysh\LaravelPhpbbBridge\Controllers\ApiController@getSession');
            Route::post('/auth-bridge/login', 'Tohtamysh\LaravelPhpbbBridge\Controllers\ApiController@doLogin');
            Route::delete('/auth-bridge/login', 'Tohtamysh\LaravelPhpbbBridge\Controllers\ApiController@doLogout');
        });
    }

    public function register()
    {
        //
    }
}
