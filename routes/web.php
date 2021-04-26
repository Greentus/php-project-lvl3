<?php

use App\Http\Controllers\UrlController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckController;
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

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/urls', [UrlController::class, 'index'])->name('urls.index');
Route::post('/urls', [UrlController::class, 'store'])->name('urls.store');
Route::get('urls/{url}', [UrlController::class, 'show'])->name('urls.show');
Route::post('urls/{url}/checks', [CheckController::class, 'store'])->name('checks.store');
