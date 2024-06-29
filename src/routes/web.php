<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('login', [\App\Http\Controllers\AuthController::class, 'auth'])->name('auth');
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth'], function () {


    Route::get('/', [\App\Http\Controllers\HomeController::class, 'home'])->name('home');
    Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [\App\Http\Controllers\HomeController::class,'profile'])->name('profile');

    Route::get('/clear/notifications',[ \App\Http\Controllers\HomeController::class, 'clearNotifications'])->name('clear.notifies');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users');
    Route::get('users/items/{offset}/{limit}', [\App\Http\Controllers\UserController::class, 'items'])->name('users.items');
    Route::post('users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::get('/users/edit/{id}', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/update/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/delete/{id}', [\App\Http\Controllers\UserController::class, 'delete'])->name('users.delete');

    Route::get('roles', [\App\Http\Controllers\RoleController::class,'index'])->name('roles');
    Route::get('roles/items/{offset}/{limit}', [\App\Http\Controllers\RoleController::class, 'items'])->name('roles.items');
    Route::post('roles/create', [\App\Http\Controllers\RoleController::class,'create'])->name('roles.create');
    Route::get('/roles/edit/{id}', [\App\Http\Controllers\RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/roles/update/{id}', [\App\Http\Controllers\RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/delete/{id}', [\App\Http\Controllers\RoleController::class, 'delete'])->name('roles.delete');

    Route::get('organizations', [\App\Http\Controllers\OrganizationController::class,'index'])->name('organizations');
    Route::get('organizations/items/{offset}/{limit}', [\App\Http\Controllers\OrganizationController::class, 'items'])->name('organizations.items');
    Route::post('organizations/create', [\App\Http\Controllers\OrganizationController::class,'create'])->name('organizations.create');
    Route::get('/organizations/edit/{id}', [\App\Http\Controllers\OrganizationController::class, 'edit'])->name('organizations.edit');
    Route::post('/organizations/update/{id}', [\App\Http\Controllers\OrganizationController::class, 'update'])->name('organizations.update');
    Route::delete('/organizations/delete/{id}', [\App\Http\Controllers\OrganizationController::class, 'delete'])->name('organizations.delete');

    Route::get('devices', [\App\Http\Controllers\DeviceController::class,'index'])->name('devices');
    Route::get('devices/items/{offset}/{limit}', [\App\Http\Controllers\DeviceController::class, 'items'])->name('device.items');
    Route::post('devices/create', [\App\Http\Controllers\DeviceController::class,'create'])->name('devices.create');
    Route::get('/devices/edit/{id}', [\App\Http\Controllers\DeviceController::class, 'edit'])->name('devices.edit');
    Route::post('/devices/update/{id}', [\App\Http\Controllers\DeviceController::class, 'update'])->name('devices.update');
    Route::delete('/devices/delete/{id}', [\App\Http\Controllers\DeviceController::class, 'delete'])->name('devices.delete');

});
