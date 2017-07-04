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


Route::auth();
Route::middleware('admin')->post('/dashboard/index',function (Request $request) {
    return $request->user();
})->name('api.dashboard.index');


/*Route::group(['namespace'=> 'Api'], function () {
    Route::post('/auth/check', 'AuthController@check');
    Route::post('/auth/logout', 'AuthController@logout');
    Route::post('/auth/login', 'AuthController@login');

});*/
Route::post('/file/upload','Api\UploadController@fileUpload');
Route::group([

    'middleware' => ['auth:api','admin'],

    'namespace' => 'Api'
],function (){

    /*Route::post('/file/upload', 'UploadController@fileUpload');*/

    Route::get('/categories', 'CategoryController@getAllList');

    Route::get('/role', 'RoleController@getAllList');
    Route::get('/role/permissions/{id}', 'RoleController@getPermissionsById');
    Route::put('/role/permission/{id}', 'RoleController@savaPermission');
    Route::get('/role/permissions', 'RoleController@getAllPermissions');
    Route::get('/permission/toppermissions', 'PermissionController@topPermissions');

    Route::get('/tags','TagController@getAllList');
    Route::get('/system', 'SystemController@getSystemInfo');
    Route::get('/article/recycle', 'ArticleController@recycle');
    Route::get('/article/recover/{id}', 'ArticleController@recover');
    Route::delete('/article/recycle/{id}', 'ArticleController@forcedelete');
    Route::get('/article/forcedelete/{id}', 'ArticleController@forcedelete');

    Route::resource('article', 'ArticleController', ['names' => [
        'index' => 'api.article.index',
        'store' => 'api.article.store',
        'edit' => 'api.article.edit',
        'update' => 'api.article.update',
        'destroy' => 'api.article.destroy',
    ]]);

    Route::resource('category', 'CategoryController', ['names' => [
        'index' => 'api.category.index',
        'store' => 'api.category.store',
        'edit' => 'api.category.edit',
        'update' => 'api.category.update',
        'destroy' => 'api.category.destroy',
    ]]);

    Route::resource('tag', 'TagController', ['names' => [
        'index' => 'api.tag.index',
        'store' => 'api.tag.store',
        'edit' => 'api.tag.edit',
        'update' => 'api.tag.update',
        'destroy' => 'api.tag.destroy',
    ]]);

    Route::resource('navigation', 'NavigationController', ['names' => [
        'index' => 'api.navigation.index',
        'store' => 'api.navigation.store',
        'edit' => 'api.navigation.edit',
        'update' => 'api.navigation.update',
        'destroy' => 'api.navigation.destroy',
    ]]);

    Route::resource('discussion', 'DiscussionController', ['names' => [
        'index' => 'api.discussion.index',
        'store' => 'api.discussion.store',
        'edit' => 'api.discussion.edit',
        'update' => 'api.discussion.update',
        'destroy' => 'api.discussion.destroy',
    ]]);

    Route::resource('comment', 'CommentController', ['names' => [
        'index' => 'api.comment.index',
        'store' => 'api.comment.store',
        'edit' => 'api.comment.edit',
        'update' => 'api.comment.update',
        'destroy' => 'api.comment.destroy',
    ]]);

    Route::resource('link', 'LinkController', ['names' => [
        'index' => 'api.link.index',
        'store' => 'api.link.store',
        'edit' => 'api.link.edit',
        'update' => 'api.link.update',
        'destroy' => 'api.link.destroy',
    ]]);


    Route::resource('admin', 'AdminController', ['names' => [
        'index' => 'api.admin.index',
        'store' => 'api.admin.store',
        'edit' => 'api.admin.edit',
        'update' => 'api.admin.update',
        'destroy' => 'api.admin.destroy',
    ]]);

    Route::resource('role', 'RoleController', ['names' => [
        'index' => 'api.role.index',
        'store' => 'api.role.store',
        'edit' => 'api.role.edit',
        'update' => 'api.role.update',
        'destroy' => 'api.role.destroy',
    ]]);

    Route::resource('permission', 'PermissionController', ['names' => [
        'index' => 'api.permission.index',
        'store' => 'api.permission.store',
        'edit' => 'api.permission.edit',
        'update' => 'api.permission.update',
        'destroy' => 'api.permission.destroy',
    ]]);

    Route::resource('user', 'UserController', ['names' => [
        'index' => 'api.user.index',
        'store' => 'api.user.store',
        'edit' => 'api.user.edit',
        'update' => 'api.user.update',
        'destroy' => 'api.user.destroy',
    ]]);


});

/*$api = app('Dingo\Api\Routing\Router');
$api->version('v1',function ($api){
    $api->post('/auth/login', 'App\Http\Controllers\Auth\AuthController@authenticate');


    $api->post('/auth/check', 'App\Http\Controllers\Auth\AuthController@check');

    //$api->post('/auth/check', ['middleware' => 'api.auth', 'App\Http\Controllers\Auth\AuthController@check');

});


$api->version('v1',['namespace' => 'App\Api\v1'],function ($api){
    $api->post('/category','CategoryController@index');
    $api->post('/category/store','CategoryController@store');
    $api->post('/category/update','CategoryController@update');
    $api->get('/category/destroy','CategoryController@destroy');
});*/