<?php

use App\Http\Controllers\admin\homeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\admin\UserController;

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
    
    'auth',
    'role:admin|super_admin'
    
    ])->group(function(){

        Route::prefix('admin')->name('admin.')->group(function(){

         //home
         Route::get('/home/top_statistics', 'HomeController@topStatistics')->name('home.top_statistics');
         Route::get('/home/movies_chart', 'HomeController@moviesChart')->name('home.movies_chart');
         Route::get('/home', 'HomeController@index')->name('home');


        //roles routes
        Route::get('/roles/data', 'RoleController@data')->name('roles.data');
        Route::delete('/roles/bulk_delete', 'RoleController@bulkDelete')->name('roles.bulk_delete');
        Route::resource('roles', 'RoleController');
    
    
        //admins routes
        Route::get('/admins/data', 'AdminController@data')->name('admins.data');
        Route::delete('/admins/bulk_delete', 'AdminController@bulkDelete')->name('admins.bulk_delete');
        Route::resource('admins', 'AdminController');
        
        //users routes
        Route::get('/users/data', 'UserController@data')->name('users.data');
        Route::delete('/users/bulk_delete', 'UserController@bulkDelete')->name('users.bulk_delete');
        Route::resource('users', 'UserController');

        //genre routes
        Route::get('/genres/data', 'GenreController@data')->name('genres.data');
        Route::delete('/genres/bulk_delete', 'GenreController@bulkDelete')->name('genres.bulk_delete');
        Route::resource('genres', 'GenreController')->only(['index', 'destroy']);

        //movie routes
        Route::get('/movies/data', 'MovieController@data')->name('movies.data');
        Route::delete('/movies/bulk_delete', 'MovieController@bulkDelete')->name('movies.bulk_delete');
        Route::resource('movies', 'MovieController')->only(['index', 'show', 'destroy']);

        //actor routes
        Route::get('/actors/data', 'ActorController@data')->name('actors.data');
        Route::delete('/actors/bulk_delete', 'ActorController@bulkDelete')->name('actors.bulk_delete');
        Route::resource('actors', 'ActorController')->only(['index', 'destroy']);





        
        //setting routes
        Route::get('/settings/general', 'SettingController@general')->name('settings.general');
        Route::resource('settings', 'SettingController')->only(['store']);

        //profile routes
        Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');
        Route::put('/profile/update', 'ProfileController@update')->name('profile.update');

        Route::name('profile.')->namespace('Profile')->group(function () {

            //password routes
            Route::get('/password/edit', 'PasswordController@edit')->name('password.edit');
            Route::put('/password/update', 'PasswordController@update')->name('password.update');

        });
      
        });

  });


