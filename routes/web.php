<?php

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

 /*
 * 后台
  * */
Route::group(['prefix' => 'api','namespace'=> 'Api'], function () {
    Route::post('/auth/check', 'AuthController@check');
    Route::post('/auth/logout', 'AuthController@logout');
    Route::post('/auth/login', 'AuthController@login');

});

Route::group(['prefix' => '/dashboard', 'middleware' => 'auth', 'namespace'=> 'Api'], function () {
//Route::group(['prefix' => '/dashboard', 'namespace'=> 'Api'], function () {
    //Route::get('/getAllCategories','CategoryController@getAllCategories');
    Route::post('/article/search','ArticleController@search');

    Route::resource('/category', 'CategoryController');
    /*Route::resource('/article', 'ArticleController');*/
    Route::resource('/tag', 'tagController');

});

Auth::routes();

Route::get('/{path?}', function () {
    return view('dashboard');
})->where('path', '[\/\w\.-]*');

