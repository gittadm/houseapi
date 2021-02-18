<?php

Route::get('categories', 'CategoryController@index');
Route::get('products', 'ProductController@index');
Route::get('products/{slug}', 'ProductController@show');

Route::get('carts/{id}', 'CartController@show');
Route::post('carts', 'CartController@store');
Route::put('carts/{id}', 'CartController@update');
Route::delete('carts/{id}', 'CartController@destroy');

Route::put('orders/{id}/status', 'OrderController@updateStatus');

Route::post('users', 'UserController@store');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('orders', 'OrderController@index');
    Route::post('auth/me', 'Auth\MeController');
});


