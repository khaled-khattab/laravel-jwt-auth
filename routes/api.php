<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'cors'], function(){
    Route::prefix('user')->group(function (){
        Route::post('register', 'UserController@register');
        Route::post('login', 'UserController@login');
        Route::post('send-password-reset-link', 'ResetPasswordController@send_password_reset_link');
        Route::post('reset-password', 'ChangePasswordController@change_password');
        Route::middleware('jwt.auth')->group(function (){
            Route::post('me', 'UserController@me');
            Route::post('logout', 'UserController@logout');
        });
    });
});