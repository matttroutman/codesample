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

// Landing Page Route
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// Dashboard Route
Route::get('/home', 'HomeController@index')->name('home');
// OAuth Routes
Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');
// Contacts Routes
Route::get('contacts', 'ContactsController@index');
Route::get('/contacts/details/{contact}', 'ContactsController@show');
Route::get('/contacts/edit', 'ContactsController@edit');
Route::get('/contacts/create', 'ContactsController@create');
Route::get('/contacts/showall', 'ContactsController@showall');
Route::get('/contacts/removedetail/{contact}', 'ContactsController@removeDetail');
Route::get('/contacts/createdetail', 'ContactsController@createDetail');
