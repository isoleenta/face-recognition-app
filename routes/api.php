<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/auth')->name('auth.')->controller('AuthController')->group(function () {
    Route::post('/register', 'handleUserRegister')->name('register');
    Route::post('/login', 'handleUserLogin')->name('login');
    Route::post('/logout', 'handleUserLogout')->middleware('auth:api')->name('logout');
});

Route::prefix('/photo')->name('photo.')->middleware('auth:api')->controller('PhotoController')->group(function () {
    Route::post('/model', 'createModel')->name('create');
    Route::post('/recognize', 'recognizeFriends')->name('recognize');
});
