<?php

/**
 * Define layout and a helper method to DRY up the use of the layout.
 *
 * @param $view string The name of the view file, like "home.index"
 * @param $vars array Key-val pairs of data to pass to the view
 * @return Illuminate\View\Factory
 */
function layout($view, $vars = []) {
	return View::make('layouts.default')->nest('content', $view, $vars);
}

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['middleware' => ['web']], function() {
  Route::auth();

  Route::get('/', 'PagesController@home');

  // Authentication routes...
  Route::get('/login', function() {
		return layout('auth.login');
	});
  Route::post('/login', 'Auth\AuthController@postLogin');
  Route::get('auth/logout', 'Auth\AuthController@getLogout');

  // Registration routes...
  Route::get('/register', function() {
		return layout('auth.register');
	});
  Route::post('auth/register', 'Auth\AuthController@postRegister');

  // TODO: Add category into the route for getting placeholders
  Route::get('clubs/{slug}/{width}x{height}', function($slug, $width, $height){
    return App\Club::with('placeholders')->where('slug', $slug)->firstOrFail()->randomPlaceholder($width, $height);
  });

  Route::resource('clubs', 'ClubsController');
  Route::get('clubs/{slug}', 'ClubsController@show');
  Route::post('clubs/{slug}/placeholders', [
    'as' => 'store_placeholder_path',
    'uses' => 'ClubsController@addPlaceholder'
  ]);

  Route::delete('placeholders/{id}', 'PlaceholdersController@destroy');

});
