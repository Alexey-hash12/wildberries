<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/login', [\App\Http\Controllers\Auth\AuthController::class, 'loginPage'])->name('login');
Route::post('/login/form', [\App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login.form');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [\App\Http\Controllers\Controller::class, 'index'])->name('index');
    Route::post('/logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');
});
