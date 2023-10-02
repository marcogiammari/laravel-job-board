<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
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

Route::get('', fn () => to_route('jobs.index'));

Route::resource('jobs', JobController::class)
    ->only(['index', 'show']);


// creiamo una rotta login a cui rimanda laravel per convenzione se si tenta di fare azioni protette da middleware di autenticazione senza essere autenticati
Route::get('login', fn () => to_route('auth.create'))->name('login');
Route::resource('auth', AuthController::class)->only(['create', 'store']);

// con una rotta delete non possiamo usare un link ma solo un form per il logout
// ma è più semantico (stiamo distruggendo la risorsa-session)
// e più sicuro: un semplice link può essere facilmente mascherato o dirottato
Route::delete('logout', fn () => to_route('auth.destroy'))->name('logout');
Route::delete('auth', [AuthController::class, 'destroy'])->name('auth.destroy');
