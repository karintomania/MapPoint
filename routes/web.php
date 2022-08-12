<?php

use App\Http\Controllers\{MainController, PointController};
use App\Http\Controllers\Auth\{RegistrationController, LoginController, LogoutController, TwitterAuthController};
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

Route::middleware(['auth'])->group(function () {
    Route::get('/', [MainController::class, 'index']);

    Route::resources([
        'points' => PointController::class,
    ]);
});
Route::get('/register', [RegistrationController::class, 'register'])->name('auth.register');
Route::post('/register', [RegistrationController::class, 'store'])->name('auth.store');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'auth'])->name('auth.auth');
Route::get('/logout', LogoutController::class)->name('auth.logout');

Route::get('/twitter-login', [TwitterAuthController::class, 'login'])->name('twitter.login');
Route::get('/twitter-redirect', [TwitterAuthController::class, 'redirect'])->name('twitter.redirect');