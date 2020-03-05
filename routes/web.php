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

Route::get('events/{event}', 'Organizations\Event\EventController@show')
    ->name('events.show');

Route::get('events/{event}/register', 'Organizations\Event\EventController@showRegistrationForm')
    ->name('events.register');

Route::post('events/{event}/register', 'Organizations\Event\EventController@processRegistration');

Route::get('events/{event}/confirm', 'Organizations\Event\EventController@showConfirmForm')
    ->name('events.confirm');

Route::post('events/{event}/confirm', 'Organizations\Event\EventController@processConfirm');

Route::match(['get', 'post'], 'events/{event}/cancel', 'Organizations\Event\EventController@cancel')
    ->name('events.cancel');

Route::get('groups/{group}', 'Organizations\OrganizationGroupController@show')
    ->name('groups.show');

Route::get('user/settings/email', 'User\SettingsController@showEmailSettings')
    ->name('settings.email');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('events/create', 'Organizations\Event\EventAdminController@create')
        ->name('admin.events.create');

    Route::post('events/create', 'Organizations\Event\EventAdminController@store')
        ->name('admin.events.store');

    Route::get('events/{event}/edit', 'Organizations\Event\EventAdminController@edit')
        ->name('admin.events.edit');

    Route::post('events/{event}/edit', 'Organizations\Event\EventAdminController@update')
        ->name('admin.events.update');

    Route::get('events/{event}/regopts/create', 'Organizations\Event\EventAdminController@createRegistrationOption')
        ->name('admin.events.regopts.create');

    Route::post('events/{event}/regopts/create', 'Organizations\Event\EventAdminController@storeRegistrationOption')
        ->name('admin.events.regopts.store');

});
