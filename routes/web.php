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

Route::view('/', 'welcome')
    ->name('home');

Route::get('auth/mattermost', 'Auth\MattermostAuthController@login')
    ->name('login');

Route::get('auth/mattermost/callback', 'Auth\MattermostAuthController@callback');

Route::post('logout', 'Auth\MattermostAuthController@logout')
    ->name('logout');

Route::resource('organizations', 'Organizations\OrganizationController');
Route::resource('events', 'Organizations\EventController');

