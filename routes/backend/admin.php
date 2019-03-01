<?php

/*
 * All route names are prefixed with 'admin.'.
 */
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', '\App\Http\Controllers\Backend\DashboardController@index')
    ->name('dashboard');

Route::get('appointments/search', '\App\Http\Controllers\AppointmentController@search');
Route::get('appointments/myAppointments', '\App\Http\Controllers\AppointmentController@getAppointments');

Route::resource('appointments', '\App\Http\Controllers\AppointmentController')
    ->except(['create', 'edit']);
