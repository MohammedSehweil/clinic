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




Route::get('clinic', [\App\Http\Controllers\Backend\Auth\Role\ClinicController::class, 'index'])->name('clinic.index');
Route::get('clinic/create', [\App\Http\Controllers\Backend\Auth\Role\ClinicController::class, 'create'])->name('clinic.create');
Route::post('clinic', [\App\Http\Controllers\Backend\Auth\Role\ClinicController::class, 'store'])->name('clinic.store');

Route::group(['prefix' => 'clinic/{clinic}'], function () {
    Route::get('edit', [\App\Http\Controllers\Backend\Auth\Role\ClinicController::class, 'edit'])->name('clinic.edit');
    Route::get('show', [\App\Http\Controllers\Backend\Auth\Role\ClinicController::class, 'show'])->name('clinic.show');
    Route::post('approve', [\App\Http\Controllers\Backend\Auth\Role\ClinicController::class, 'approve'])->name('clinic.approve');
    Route::post('reject', [\App\Http\Controllers\Backend\Auth\Role\ClinicController::class, 'reject'])->name('clinic.reject');
    Route::patch('/', [\App\Http\Controllers\Backend\Auth\Role\ClinicController::class, 'update'])->name('clinic.update');
    Route::delete('/', [\App\Http\Controllers\Backend\Auth\Role\ClinicController::class, 'destroy'])->name('clinic.destroy');
});



Route::get('doctor', [\App\Http\Controllers\Backend\Auth\Role\DoctorController::class, 'index'])->name('doctor.index');
Route::get('doctor/create', [\App\Http\Controllers\Backend\Auth\Role\DoctorController::class, 'create'])->name('doctor.create');
Route::post('doctor', [\App\Http\Controllers\Backend\Auth\Role\DoctorController::class, 'store'])->name('doctor.store');

Route::group(['prefix' => 'doctor/{doctor}'], function () {
    Route::get('edit', [\App\Http\Controllers\Backend\Auth\Role\DoctorController::class, 'edit'])->name('doctor.edit');
    Route::get('show', [\App\Http\Controllers\Backend\Auth\Role\DoctorController::class, 'show'])->name('doctor.show');
    Route::patch('/', [\App\Http\Controllers\Backend\Auth\Role\DoctorController::class, 'update'])->name('doctor.update');
    Route::delete('/', [\App\Http\Controllers\Backend\Auth\Role\DoctorController::class, 'destroy'])->name('doctor.destroy');
});



Route::get('patient', [\App\Http\Controllers\Backend\Auth\Role\PatientController::class, 'index'])->name('patient.index');
Route::get('patient/create', [\App\Http\Controllers\Backend\Auth\Role\PatientController::class, 'create'])->name('patient.create');
Route::post('patient', [\App\Http\Controllers\Backend\Auth\Role\PatientController::class, 'store'])->name('patient.store');

Route::group(['prefix' => 'patient/{patient}'], function () {
    Route::get('edit', [\App\Http\Controllers\Backend\Auth\Role\PatientController::class, 'edit'])->name('patient.edit');
    Route::get('show', [\App\Http\Controllers\Backend\Auth\Role\PatientController::class, 'show'])->name('patient.show');
    Route::patch('/', [\App\Http\Controllers\Backend\Auth\Role\PatientController::class, 'update'])->name('patient.update');
    Route::delete('/', [\App\Http\Controllers\Backend\Auth\Role\PatientController::class, 'destroy'])->name('patient.destroy');
});


Route::group([
    'prefix'     => 'auth',
    'as'         => 'auth.',
    'namespace'  => 'Auth',
    'middleware' => 'role:'.config('access.users.admin_role'),
], function () {
    /*
     * User Management
     */
    Route::group(['namespace' => 'User'], function () {

        /*
         * User Status'
         */
        Route::get('user/deactivated', [UserStatusController::class, 'getDeactivated'])->name('user.deactivated');
        Route::get('user/deleted', [UserStatusController::class, 'getDeleted'])->name('user.deleted');

        /*
         * User CRUD
         */
        Route::get('user', [UserController::class, 'index'])->name('user.index');
        Route::get('user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('user', [UserController::class, 'store'])->name('user.store');

        /*
         * Specific User
         */
        Route::group(['prefix' => 'user/{user}'], function () {
            // User
            Route::get('/', [UserController::class, 'show'])->name('user.show');
            Route::get('edit', [UserController::class, 'edit'])->name('user.edit');
            Route::patch('/', [UserController::class, 'update'])->name('user.update');
            Route::delete('/', [UserController::class, 'destroy'])->name('user.destroy');

            // Account
            Route::get('account/confirm/resend', [UserConfirmationController::class, 'sendConfirmationEmail'])->name('user.account.confirm.resend');

            // Status
            Route::get('mark/{status}', [UserStatusController::class, 'mark'])->name('user.mark')->where(['status' => '[0,1]']);

            // Social
            Route::delete('social/{social}/unlink', [UserSocialController::class, 'unlink'])->name('user.social.unlink');

            // Confirmation
            Route::get('confirm', [UserConfirmationController::class, 'confirm'])->name('user.confirm');
            Route::get('unconfirm', [UserConfirmationController::class, 'unconfirm'])->name('user.unconfirm');

            // Password
            Route::get('password/change', [UserPasswordController::class, 'edit'])->name('user.change-password');
            Route::patch('password/change', [UserPasswordController::class, 'update'])->name('user.change-password.post');

            // Access
            Route::get('login-as', [UserAccessController::class, 'loginAs'])->name('user.login-as');

            // Session
            Route::get('clear-session', [UserSessionController::class, 'clearSession'])->name('user.clear-session');

            // Deleted
            Route::get('delete', [UserStatusController::class, 'delete'])->name('user.delete-permanently');
            Route::get('restore', [UserStatusController::class, 'restore'])->name('user.restore');
        });
    });

    /*
     * Role Management
     */
    Route::group(['namespace' => 'Role'], function () {
        Route::get('role', [RoleController::class, 'index'])->name('role.index');
        Route::get('role/create', [RoleController::class, 'create'])->name('role.create');
        Route::post('role', [RoleController::class, 'store'])->name('role.store');

        Route::group(['prefix' => 'role/{role}'], function () {
            Route::get('edit', [RoleController::class, 'edit'])->name('role.edit');
            Route::patch('/', [RoleController::class, 'update'])->name('role.update');
            Route::delete('/', [RoleController::class, 'destroy'])->name('role.destroy');
        });
    });





});
