<?php

// Authentication Routes
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/{any}', 'AppController@index')->where('any', '.*');

Route::fallback(function(){
    return response()->json(['message' => 'Page Not Found'], 404);
});