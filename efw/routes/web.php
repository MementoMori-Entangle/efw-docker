<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/fabric', [App\Http\Controllers\FabricController::class, 'index'])->name('fabric');
Route::post('/fabric', [App\Http\Controllers\FabricController::class, 'store'])->name('fabric');
Route::delete('/fabric/{id}', [App\Http\Controllers\FabricController::class, 'destroy'])->name('fabric');
