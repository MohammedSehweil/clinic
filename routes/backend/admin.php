<?php

/*
 * All route names are prefixed with 'admin.'.
 */
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', '\App\Http\Controllers\Backend\DashboardController@index')
    ->name('dashboard');
