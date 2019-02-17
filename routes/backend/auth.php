<?php

use App\Http\Controllers\Backend\Auth\Role\RoleController;
use App\Http\Controllers\Backend\Auth\User\UserController;
use App\Http\Controllers\Backend\Auth\User\UserAccessController;
use App\Http\Controllers\Backend\Auth\User\UserSocialController;
use App\Http\Controllers\Backend\Auth\User\UserStatusController;
use App\Http\Controllers\Backend\Auth\User\UserSessionController;
use App\Http\Controllers\Backend\Auth\User\UserPasswordController;
use App\Http\Controllers\Backend\Auth\User\UserConfirmationController;

/*
 * All route names are prefixed with 'admin.auth'.
 */


Route::group(['middleware' => 'redirect_if_private'], function () {
    Route::get('clinic', 'Auth\Role\ClinicController@index')
        ->name('clinic.index');

    Route::get('clinic/create', 'Auth\Role\ClinicController@create')
        ->name('clinic.create');

    Route::post('clinic', 'Auth\Role\ClinicController@store')
        ->name('clinic.store');

    Route::group(['prefix' => 'clinic/{clinic}'], function () {
        Route::get('edit', 'Auth\Role\ClinicController@edit')
            ->name('clinic.edit');

        Route::get('show', 'Auth\Role\ClinicController@show')
            ->name('clinic.show');

        Route::post('approve', 'Auth\Role\ClinicController@approve')
            ->name('clinic.approve');

        Route::post('reject', 'Auth\Role\ClinicController@reject')
            ->name('clinic.reject');

        Route::patch('/', 'Auth\Role\ClinicController@update')
            ->name('clinic.update');

        Route::delete('/', 'Auth\Role\ClinicController@destroy')
            ->name('clinic.destroy');
    });

    Route::get('lab', 'Auth\Role\LabController@index')
        ->name('lab.index');

    Route::get('lab/create', 'Auth\Role\LabController@create')
        ->name('lab.create');

    Route::post('lab', 'Auth\Role\LabController@store')
        ->name('lab.store');

    Route::group(['prefix' => 'lab/{lab}'], function () {
        Route::get('edit', 'Auth\Role\LabController@edit')
            ->name('lab.edit');

        Route::get('show', 'Auth\Role\LabController@show')
            ->name('lab.show');

        Route::post('approve', 'Auth\Role\LabController@approve')
            ->name('lab.approve');

        Route::post('reject', 'Auth\Role\LabController@reject')
            ->name('lab.reject');

        Route::patch('/', 'Auth\Role\LabController@update')
            ->name('lab.update');

        Route::delete('/', 'Auth\Role\LabController@destroy')
            ->name('lab.destroy');
    });

    Route::get('doctor', 'Auth\Role\DoctorController@index')
        ->name('doctor.index');

    Route::get('doctor/create', 'Auth\Role\DoctorController@create')
        ->name('doctor.create');

    Route::post('doctor', 'Auth\Role\DoctorController@store')
        ->name('doctor.store');

    Route::group(['prefix' => 'doctor/{doctor}'], function () {
        Route::get('edit', 'Auth\Role\DoctorController@edit')->name('doctor.edit');
        Route::get('show', 'Auth\Role\DoctorController@show')->name('doctor.show');
        Route::patch('/', 'Auth\Role\DoctorController@update')->name('doctor.update');
        Route::delete('/', 'Auth\Role\DoctorController@destroy')->name('doctor.destroy');
    });


    Route::get('patient', 'Auth\Role\PatientController@index')
        ->name('patient.index');

    Route::get('patient/create', 'Auth\Role\PatientController@create')
        ->name('patient.create');

    Route::post('patient', 'Auth\Role\PatientController@store')
        ->name('patient.store');

    Route::group(['prefix' => 'patient/{patient}'], function () {
        Route::get('edit', 'Auth\Role\PatientController@edit')->name('patient.edit');
        Route::get('show', 'Auth\Role\PatientController@show')->name('patient.show');
        Route::patch('/', 'Auth\Role\PatientController@update')->name('patient.update');
        Route::delete('/', 'Auth\Role\PatientController@destroy')->name('patient.destroy');
    });
});


Route::get('private-doctor/{privatedoctor}/create', 'Auth\Role\PrivateDoctorController@create')
    ->name('private-doctor.create');
Route::post('private-doctor/{privatedoctor}', 'Auth\Role\PrivateDoctorController@store')
    ->name('private-doctor.store');

Route::group(['middleware' => 'redirect_if_private'], function () {
    Route::get('private-doctor', 'Auth\Role\PrivateDoctorController@index')
        ->name('private-doctor.index');

    Route::group(['prefix' => 'private-doctor/{privatedoctor}'], function () {
        Route::get('edit', 'Auth\Role\PrivateDoctorController@edit')->name('private-doctor.edit');
        Route::get('show', 'Auth\Role\PrivateDoctorController@show')->name('private-doctor.show');
        Route::post('approve', 'Auth\Role\PrivateDoctorController@approve')->name('private-doctor.approve');
        Route::post('reject', 'Auth\Role\PrivateDoctorController@reject')->name('private-doctor.reject');
        Route::patch('/', 'Auth\Role\PrivateDoctorController@update')->name('private-doctor.update');
        Route::delete('/', 'Auth\Role\PrivateDoctorController@destroy')->name('private-doctor.destroy');
    });
});


Route::get('nurse/{nurse}/create', 'Auth\Role\NurseController@create')->name('nurse.create');
Route::post('nurse/{nurse}', 'Auth\Role\NurseController@store')->name('nurse.store');

Route::group(['middleware' => 'redirect_if_private'], function () {
    Route::get('nurse', 'Auth\Role\NurseController@index')->name('nurse.index');

    Route::group(['prefix' => 'nurse/{nurse}'], function () {
        Route::get('edit', 'Auth\Role\NurseController@edit')->name('nurse.edit');
        Route::get('show', 'Auth\Role\NurseController@show')->name('nurse.show');
        Route::post('approve', 'Auth\Role\NurseController@approve')->name('nurse.approve');
        Route::post('reject', 'Auth\Role\NurseController@reject')->name('nurse.reject');
        Route::patch('/', 'Auth\Role\NurseController@update')->name('nurse.update');
        Route::delete('/', 'Auth\Role\NurseController@destroy')->name('nurse.destroy');
    });
});


Route::group(['middleware' => 'role:'.config('access.users.admin_role')], function () {
    /*
     * User Management
     */
    Route::group(['namespace' => 'Auth\User'], function () {
        Route::get('user/deactivated', 'UserStatusController@getDeactivated')
            ->name('user.deactivated');

        Route::get('user/deleted', 'UserStatusController@getDeleted')
            ->name('user.deleted');

        Route::get('user', 'UserController@index')
            ->name('user.index');

        Route::get('user/create', 'UserController@create')->name('user.create');
        Route::post('user', 'UserController@store')->name('user.store');

        /*
         * Specific User
         */
        Route::group(['prefix' => 'user/{user}'], function () {
            // User
            Route::get('/', 'UserController@show')->name('user.show');
            Route::get('edit', 'UserController@edit')->name('user.edit');
            Route::patch('/', 'UserController@update')->name('user.update');
            Route::delete('/', 'UserController@destroy')->name('user.destroy');

            // Account
            Route::get('account/confirm/resend', 'UserConfirmationController@sendConfirmationEmail')
                ->name('user.account.confirm.resend');

            // Status
            Route::get('mark/{status}', 'UserStatusController@mark')
                ->name('user.mark')
                ->where(['status' => '[0,1]']);

            // Social
            Route::delete('social/{social}/unlink', 'UserSocialController@unlink')
                ->name('user.social.unlink');

            // Confirmation
            Route::get('confirm', 'UserConfirmationController@confirm')->name('user.confirm');
            Route::get('unconfirm', 'UserConfirmationController@unconfirm')->name('user.unconfirm');

            // Password
            Route::get('password/change', 'UserPasswordController@edit')->name('user.change-password');
            Route::patch('password/change', 'UserPasswordController@update')->name('user.change-password.post');

            // Access
            Route::get('login-as', 'UserAccessController@loginAs')->name('user.login-as');

            // Session
            Route::get('clear-session', 'UserSessionController@clearSession')->name('user.clear-session');

            // Deleted
            Route::get('delete', 'UserStatusController@delete')->name('user.delete-permanently');
            Route::get('restore', 'UserStatusController@restore')->name('user.restore');
        });
    });

    /*
     * Role Management
     */
    Route::group(['namespace' => 'Auth\Role'], function () {
        Route::get('role', 'RoleController@index')->name('role.index');
        Route::get('role/create', 'RoleController@create')->name('role.create');
        Route::post('role', 'RoleController@store')->name('role.store');

        Route::group(['prefix' => 'role/{role}'], function () {
            Route::get('edit', 'RoleController@edit')->name('role.edit');
            Route::patch('/', 'RoleController@update')->name('role.update');
            Route::delete('/', 'RoleController@destroy')->name('role.destroy');
        });
    });
});
