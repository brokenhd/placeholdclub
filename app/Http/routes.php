<?php

Route::group(['middleware' => ['web']], function() {
  Route::auth();

  Route::get('/', 'PagesController@home');

  // Authentication routes...
  Route::get('auth/login', 'Auth\AuthController@getLogin');
  Route::post('auth/login', 'Auth\AuthController@postLogin');
  Route::get('auth/logout', 'Auth\AuthController@getLogout');

  // Registration routes...
  Route::get('auth/register', 'Auth\AuthController@getRegister');
  Route::post('auth/register', 'Auth\AuthController@postRegister');

  Route::resource('clubs', 'ClubsController');
  Route::get('clubs/{slug}', 'ClubsController@show');
  Route::post('clubs/{slug}/placeholders', [
    'as' => 'store_placeholder_path',
    'uses' => 'ClubsController@addPlaceholder'
  ]);

});
