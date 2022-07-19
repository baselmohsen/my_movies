<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');

//genre routes
Route::get('/genres', 'GenreController@index');

//movie routes
Route::get('/movies/{movie}/images', 'MovieController@images');
Route::get('/movies/{movie}/actors', 'MovieController@actors');
Route::get('/movies/{movie}/related_movies', 'MovieController@relatedMovies');
Route::get('/movies', 'MovieController@index');

Route::middleware('auth:sanctum')->group(function () {

    //movie routes
    Route::get('/movies/toggle_movie', 'MovieController@toggleFavorite');

    //user route
    Route::get('/user', 'AuthController@user');
});