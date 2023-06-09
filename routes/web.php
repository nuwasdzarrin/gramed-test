<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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
    return response()->redirectToRoute('buku.index');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('buku', Controllers\BookController::class);
});
