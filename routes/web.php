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

Route::get('/', function () {
    return view('welcome');
});
//用户注册
     //个人中心
Route::post('/pass/login','Pass\PassController@login');
Route::get('/pass/userl','Pass\PassController@userl');
Route::get('/pass/aaa','Pass\PassController@aaa');
Route::get('/aaa','Login\LoginController@aaa');
Route::post('/pss','Pass\PassController@pss');
Route::post('/reg','Pass\PassController@reg');
Route::post('/user/userl','UserController@userl');
Route::post('/user/login','UserController@login');

