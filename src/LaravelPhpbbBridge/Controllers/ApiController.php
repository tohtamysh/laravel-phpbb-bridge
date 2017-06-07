<?php

namespace Tohtamysh\LaravelPhpbbBridge\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function doLogin(Request $request)
    {
        $appkey = $request->input('appkey');
        $username = $request->input('username');
        $password = $request->input('password');
        if ($appkey !== config('laravel-phpbb-bridge.appkey')) {
            return response()->json(['code' => '400', 'msg' => 'Invalid API Key', 'data' => []]);
        }
        if ($data = $this->_validateCredentials($username, $password)) {
            return response()->json(['code' => '200', 'msg' => 'success', 'data' => $data]);
        }

        return response()->json(['code' => '400', 'msg' => 'Invalid username or password', 'data' => []]);
    }

    public function getSession()
    {
        if (config('laravel-phpbb-bridge.client_auth') && Auth::client()->check()) {
            $result = ['username' => Auth::client()->user()[config('laravel-phpbb-bridge.user_model.username_column')]];
        } elseif (!config('laravel-phpbb-bridge.client_auth') && Auth::check()) {
            $result = ['username' => Auth::user()[config('laravel-phpbb-bridge.user_model.username_column')]];
        } else {
            $result = [];
        }
        return response()->json(['code' => '200', 'data' => $result]);
    }

    public function doLogout()
    {
        if (config('laravel-phpbb-bridge.client_auth') && Auth::client()->check()) {
            Auth::client()->logout();
        } elseif (!config('laravel-phpbb-bridge.client_auth') && Auth::check()) {
            Auth::logout();
        }
    }

    private function _validateCredentials($username, $password)
    {
        $username = trim($username);
        $password = trim($password);

        if (config('laravel-phpbb-bridge.client_auth') && Auth::client()->attempt([config('laravel-phpbb-bridge.user_model.username_column') => $username, config('laravel-phpbb-bridge.user_model.password_column') => $password])
            || (!config('laravel-phpbb-bridge.client_auth') && Auth::attempt([config('laravel-phpbb-bridge.user_model.username_column') => $username, config('laravel-phpbb-bridge.user_model.password_column') => $password]))
        ) {
            return (config('laravel-phpbb-bridge.client_auth')) ? Auth::client()->user() : Auth::user();
        }

        return false;
    }
}
