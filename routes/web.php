<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvancedController;
use App\Http\Controllers\EnlaceController;
use App\Http\Controllers\EtiquetaController;
use App\Http\Controllers\EnlaceEtiquetaController;
// use Auth;
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


Route::resource('/admin', AdminController::class);
// Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/show', [App\Http\Controllers\HomeController::class, 'show'])->name('home.show');
Route::get('/home/edit', [App\Http\Controllers\HomeController::class, 'edit'])->name('home.edit');
Route::PUT('/home/update', [App\Http\Controllers\HomeController::class, 'update'])->name('home.update');

Route::resource('/advanced', AdvancedController::class);

Route::get('/salir', function () {
    Auth::logout();
    return redirect('/');
});

Route::resource('enlace', EnlaceController::class);
Route::resource('etiqueta', EtiquetaController::class);

Route::get('enlace/visita/{enlace}', [App\Http\Controllers\EnlaceController::class, 'visita'])->name('visita');

Route::resource('enlaceEtiqueta', EnlaceEtiquetaController::class);

Route::get('enlaceEtiqueta/index}', [App\Http\Controllers\EnlaceEtiquetaController::class, 'indexnew'])->name('indexnew');


