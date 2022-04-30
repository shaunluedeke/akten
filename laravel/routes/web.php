<?php

use App\Http\Controllers\Admin\FraktionController;
use App\Http\Controllers\Admin\RangController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::redirect('/', "login");

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/akten', App\Http\Controllers\AktenController::class);

Route::resource('/persons', App\Http\Controllers\PersonsController::class);

Route::resource('/bussgeld', \App\Http\Controllers\BussgeldController::class);

Route::prefix("/admin")->group(function () {

    Route::get('/', static function () {
        return view('admin.index');
    })->middleware('auth','password.confirm')->name('admin.index');

    Route::resource('/fraktion', FraktionController::class);
    Route::resource('/rang', RangController::class);
    Route::resource('/user', UserController::class);
});

Route::get('/pwedit', function () {
    return view('pwedit');
})->middleware('auth','password.confirm')->name('pwedit');

Route::post('/pwedit', [App\Http\Controllers\HomeController::class, 'updateeditpw']);
