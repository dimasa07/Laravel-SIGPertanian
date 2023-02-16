<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebAPIController;
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

Route::controller(Controller::class)
    ->group(function(){
        Route::get('/', 'index')->name('home');
    });

Route::prefix('/web-api')
    ->controller(WebAPIController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/sawah', 'getAllSawah');
        Route::post('/sawah/add', 'addSawah');
        Route::get('/sawah/get/{id}', 'getSawahById')->name('sawah.get.id');
        Route::post('/sawah/update', 'updateSawah')->name('sawah.update');
        Route::get('/sawah/delete/{id}', 'deleteSawah')->name('sawah.delete');
    });

Route::prefix('/auth')
    ->controller(AuthController::class)
    ->group(function () {
        Route::get('/', 'form')->name('auth.form');
        Route::post('/login', 'login')->name('auth.login');
        Route::post('/register', 'register')->name('auth.register');
    });

Route::prefix('/admin')
    ->controller(AdminController::class)
    ->group(function () {
        Route::get('/', 'index')->name('admin');
        Route::get('/list', 'list');
    });
