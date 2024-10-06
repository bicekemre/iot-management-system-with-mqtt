<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


Route::get('login', [\App\Http\Controllers\AuthController::class, 'auth'])->name('auth');
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::permanentRedirect('/', '/'.app()->getLocale());

Route::group(['middleware' => 'auth'], function () {

    Route::group(['prefix' => '{locale}', 'middleware' => \App\Http\Middleware\Localization::class], function () {
        Route::get('/', [\App\Http\Controllers\HomeController::class, 'home'])->name('home');
        Route::get('/profile', [\App\Http\Controllers\HomeController::class,'profile'])->name('profile');

        Route::get('devices', [\App\Http\Controllers\DeviceController::class,'index'])->name('devices');

        Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users');

        Route::get('roles', [\App\Http\Controllers\RoleController::class,'index'])->name('roles');

        Route::get('organizations', [\App\Http\Controllers\OrganizationController::class,'index'])->name('organizations');

        Route::get('types', [\App\Http\Controllers\TypeController::class,'index'])->name('types');

        Route::get('/assignments',[\App\Http\Controllers\AssignmentsController::class, 'index'])->name('assignments');
    });


    Route::get('/clear/notifications',[ \App\Http\Controllers\HomeController::class, 'clearNotifications'])->name('clear.notifies');
    Route::post('/profile/update', [\App\Http\Controllers\UserController::class,'updateProfile'])->name('profile.update');
    Route::get('/devices/chart/{id}', [\App\Http\Controllers\HomeController::class, 'chart'])->name('devices.chart');

    Route::get('users/items/{offset}/{limit}', [\App\Http\Controllers\UserController::class, 'items'])->name('users.items');
    Route::post('users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::get('/users/edit/{id}', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/update/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/delete/{id}', [\App\Http\Controllers\UserController::class, 'delete'])->name('users.delete');

    Route::get('roles/items/{offset}/{limit}', [\App\Http\Controllers\RoleController::class, 'items'])->name('roles.items');
    Route::post('roles/create', [\App\Http\Controllers\RoleController::class,'create'])->name('roles.create');
    Route::get('/roles/edit/{id}', [\App\Http\Controllers\RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/roles/update/{id}', [\App\Http\Controllers\RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/delete/{id}', [\App\Http\Controllers\RoleController::class, 'delete'])->name('roles.delete');

    Route::get('organizations/items/{offset}/{limit}', [\App\Http\Controllers\OrganizationController::class, 'items'])->name('organizations.items');
    Route::post('organizations/create', [\App\Http\Controllers\OrganizationController::class,'create'])->name('organizations.create');
    Route::get('/organizations/edit/{id}', [\App\Http\Controllers\OrganizationController::class, 'edit'])->name('organizations.edit');
    Route::post('/organizations/update/{id}', [\App\Http\Controllers\OrganizationController::class, 'update'])->name('organizations.update');
    Route::delete('/organizations/delete/{id}', [\App\Http\Controllers\OrganizationController::class, 'delete'])->name('organizations.delete');
    Route::post('/organization/setcookie', [\App\Http\Controllers\OrganizationController::class,'setCookie'])->name('organization.setcookie');
    Route::post('/organization/removecookie', [\App\Http\Controllers\OrganizationController::class,'removeCookie'])->name('organization.removecookie');

    Route::get('devices/items/{offset}/{limit}', [\App\Http\Controllers\DeviceController::class, 'items'])->name('device.items');
    Route::get('devices/item/{id}', [\App\Http\Controllers\DeviceController::class, 'item'])->name('device.item');
    Route::post('devices/create', [\App\Http\Controllers\DeviceController::class,'create'])->name('devices.create');
    Route::get('/devices/edit/{id}', [\App\Http\Controllers\DeviceController::class, 'edit'])->name('devices.edit');
    Route::post('/devices/update/{id}', [\App\Http\Controllers\DeviceController::class, 'update'])->name('devices.update');
    Route::delete('/devices/delete/{id}', [\App\Http\Controllers\DeviceController::class, 'delete'])->name('devices.delete');

    Route::get('type/items/{offset}/{limit}', [\App\Http\Controllers\TypeController::class, 'items'])->name('type.items');
    Route::post('type/create', [\App\Http\Controllers\TypeController::class,'create'])->name('type.create');
    Route::get('/type/edit/{id}', [\App\Http\Controllers\TypeController::class, 'edit'])->name('type.edit');
    Route::post('/type/update/{id}', [\App\Http\Controllers\TypeController::class, 'update'])->name('type.update');
    Route::delete('/type/delete/{id}', [\App\Http\Controllers\TypeController::class, 'delete'])->name('type.delete');

    Route::get('/assignments/items/{offset}/{limit}', [\App\Http\Controllers\AssignmentsController::class, 'items'])->name('assignments.items');
    Route::get('/assignments/set/{id}', [\App\Http\Controllers\AssignmentsController::class, 'set'])->name('assignments.set');
    Route::post('/assignments/create', [\App\Http\Controllers\AssignmentsController::class,'create'])->name('assignments.create');
    Route::get('/assignments/edit/{id}', [\App\Http\Controllers\AssignmentsController::class, 'edit'])->name('assignments.edit');
    Route::post('/assignments/update/{id}', [\App\Http\Controllers\AssignmentsController::class, 'update'])->name('assignments.update');
    Route::delete('/assignments/delete/{id}', [\App\Http\Controllers\AssignmentsController::class, 'delete'])->name('assignments.delete');
});

