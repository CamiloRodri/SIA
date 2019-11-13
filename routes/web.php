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

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.in');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');


/*
// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
*/
// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
Route::get('reset', 'Auth\ResetController@index')->name('reset.index');
Route::get('reset/pass/{id?}/{clave?}', 'Auth\ResetController@update')->name('reset.update');


Route::get('/las', function () {
    symlink('/home/siaudecc/siav3/storage/app/public', '/home/siaudecc/public_html/storage');
});


Route::get('/', 'Publico\HomeController@index')->name('home');
Route::resource('encuestas', 'Publico\EncuestasController', ['as' => 'public']);
Route::get('grupos/{slug_proceso}', 'Publico\EncuestasController@index');
Route::get('encuesta/{slug_proceso}/{grupo}/{cargo?}', array('as' => 'encuestas', 'uses' => 'Publico\EncuestasController@create'));

Route::get('/cal', function () {
    return view('autoevaluacion.SuperAdministrador.CalendarioPlanMejoramiento.cal');
});