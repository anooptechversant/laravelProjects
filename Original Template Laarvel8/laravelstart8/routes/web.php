<?php

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

Route::get('/', function () {
    return view('welcome');
});
/*Route::middleware(['first', 'second'])->group(function () {
 
});*/


Route::get('admin/logout','Admin\Login@logout');

Route::get('hash365','Admin\Login@hash365');


Route::group(['prefix' => 'admin','middleware' => 'CustAuth'], function () {

 // Route::get('/','Admin\Login@index');
 // Route::get('login','Admin\Login@index');
 // Route::post('login','Admin\Login@login');
 Route::get('login','Admin\Login@index');
 Route::post('login','Admin\Login@login');
 Route::get('/','Admin\Login@index');
 Route::get('dashboard','Admin\Dashboard@index');
 Route::match(['get', 'post'], 'reset-password', 'Admin\Login@respass');
 Route::get('menu-management', 'Admin\MenuController@index');
 Route::post('menu-management-add', 'Admin\MenuController@add');
 Route::post('menu-management-edit', 'Admin\MenuController@edit');
 Route::get('menu-management-status', 'Admin\MenuController@status');
 Route::get('menu-management-delete', 'Admin\MenuController@delete');
 
 Route::get('list-admin', 'Admin\UserController@index');
 Route::post('list-admin-add', 'Admin\UserController@create');
 Route::post('list-admin-edit', 'Admin\UserController@edit');
 Route::get('list-admin-status', 'Admin\UserController@status');
 Route::get('list-admin-delete', 'Admin\UserController@destroy');
 
 Route::get('list-page', 'Admin\PageController@index');
 Route::match(['get', 'post'], 'add-page', 'Admin\PageController@create');
 Route::match(['get', 'post'], 'edit-page', 'Admin\PageController@edit');
 Route::get('page-status', 'Admin\PageController@status');
 Route::get('delete-page', 'Admin\PageController@destroy');
 Route::get('delete-page-image', 'Admin\PageController@destroyimage');
 
 Route::get('list-news', 'Admin\NewsController@index');
 Route::match(['get', 'post'], 'add-news', 'Admin\NewsController@create');
 Route::match(['get', 'post'], 'edit-news', 'Admin\NewsController@edit');
 Route::get('news-status', 'Admin\NewsController@status');
 Route::get('delete-news', 'Admin\NewsController@destroy');
 Route::get('delete-news-image', 'Admin\NewsController@destroyimage');
 Route::get('delete-news-sub-image', 'Admin\NewsController@destroysubimage');
 
 
});
