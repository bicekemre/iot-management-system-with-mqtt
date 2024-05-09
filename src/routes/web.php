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

    Route::get('roles', [\App\Http\Controllers\RoleController::class,'index'])->name('roles');
});
