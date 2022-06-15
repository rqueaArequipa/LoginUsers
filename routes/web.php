<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConnectController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Rutas nuevas y controladores
Route::get('/Login',[ConnectController::class, 'Login'])
    ->name('Login');
Route::post('/Login',[ConnectController::class, 'store'])
    ->name('store');
Route::get('/Register',[ConnectController::class, 'Register'])
    ->name('Register');
Route::post('/Register',[ConnectController::class, 'Create'])
    ->name('Create');
Route::get('/Logout',[ConnectController::class, 'Destroy'])
    ->name('Login.Destroy');

/*Route::get('/Producto/{id}/edit', [App\Http\Controllers\ProductoController::class, 'edit']);
Route::POST('/Producto/update/{id}', [App\Http\Controllers\ProductoController::class, 'update']);
Route::get('/Producto/{id}/delete', [App\Http\Controllers\ProductoController::class, 'delete']);*/




