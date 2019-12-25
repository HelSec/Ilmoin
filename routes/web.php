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

Route::get('organizations', 'Organizations\OrganizationController@index')
    ->name('organizations.index');

Route::get('organizations/{organization}', 'Organizations\OrganizationController@show')
    ->name('organizations.show');

Route::get('events/{event}', 'Organizations\EventController@show')
    ->name('events.show');

Route::match(['get', 'post'], 'events/{event}/register', 'Organizations\EventController@register')
    ->name('events.register');

Route::get('groups/{group}', 'Organizations\OrganizationGroupController@show')
    ->name('groups.show');

