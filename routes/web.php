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
//Route::get('/pass/login','Pass\PassController@login');
Route::post('/pass/login','Pass\PassController@login');
Route::get('/pass/userl','Pass\PassController@userl');
Route::get('/pass/aaa','Pass\PassController@aaa');
Route::get('/aaa','Login\LoginController@aaa');
Route::post('/pss','Pass\PassController@pss');
Route::post('/reg','Pass\PassController@reg');
Route::post('/user/userl','UserController@userl');
Route::post('/user/login','UserController@login');
Route::post('/user/list','UsersController@cartShow');
Route::get('/openssl','Openssl\OpensslController@openssl');
Route::get('/openssl/index','OpensslController@index');


Route::get('/demo', 'User\UssController@demo');//访问登录页面
Route::post('/demo2', 'User\UssController@demo2');//访问登录页面
Route::get('/demo3', 'User\UssController@demo3');//访问登录页面

Route::post('/goods/list','Goods\GoodsController@goods');   //商品数据接口
Route::post('/goods/details','Goods\GoodsController@details');
Route::post('/goods/openssl','Goods\OpensslController@details');

