<?php

use App\Http\Controllers\dashboard\homeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware([
    // 'localeSessionRedirect',
    // 'localizationRedirect',
    // 'localeViewPath',
])
->group(function () {

    Route::get('/', 'WelcomeController@index')->name('welcome');

    Route::get('/home', 'HomeController@index')->name('home');



});

Auth::routes(['register'=>false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
