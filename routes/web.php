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
Auth::routes();

Route::view('/', 'welcome');
Route::redirect('/home', '/dashboard');

//Route::get('/home', 'HomeController@index')->name('home');
Route::middleware(['auth'])->group(function() {

	// Clients
	Route::view('/clients', 'parts.clients.clients');
	Route::get('/clients/all', 'ClientController@getAll');

	// Session Notes
	Route::get('/session/notes/{clientID}', 'SessionNotesController@getClientsNotes');
	Route::post('/session/notes/store', 'SessionNotesController@store');

	// Dashboard
	Route::view('/dashboard', 'dashboard')->middleware('auth');

	//Schedule
	Route::view('/schedule', 'parts.schedule.schedule');
	Route::get('/appointments/today', 'AppointmentsController@todaysAppointments');
	Route::get('/schedule/week', 'AppointmentsController@thisWeeksAppointments');

	// Users
	Route::get('/user/login-status', 'UserController@UserLoginStatus');

});


