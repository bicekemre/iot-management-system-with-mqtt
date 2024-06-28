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
});
