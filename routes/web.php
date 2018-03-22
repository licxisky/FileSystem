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

Route::get('/size',  'FileController@size');
Route::get('/edit',    'FileController@edit');
Route::get('/share/{id}', 'FileController@share');
Route::get('/cancel/{id}', 'FileController@cancel');
Route::get('/file/{name?}/{page?}/{size?}', 'FileController@file');
Route::get('/{path?}', function ($path = "login") { return view($path); });

Route::post('/login',       'LoginController@login');
Route::post('/register',    'LoginController@register');

Route::post('/upload',  'FileController@upload');


Route::get('/download/{key?}/{value?}/{page?}/{size?}', 'FileController@download');
Route::get('/extension/{extension?}/{page?}/{size?}',   'FileController@extension');
Route::get('/type/{type?}/{page?}/{size?}',             'FileController@type');
Route::get('/remark/{remark?}/{page?}/{size?}',         'FileController@remark');
Route::get('/time/{date?}/{page?}/{size?}',             'FileController@date');
Route::get('/search/{key?}/{page?}/{size?}',            'FileController@search');