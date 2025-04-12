<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;

use App\Http\Middleware\isMembre;
use App\Http\Middleware\isCA;
use App\Http\Middleware\checkProfile;
use App\Http\Middleware\Language;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', Language::class])->group(function () {
    Route::get('/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::post('/editProfile', [DashboardController::class, 'editProfile']);
});

Route::middleware(['auth', checkProfile::class, Language::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'home'])->name('dashboard.home');
    Route::get('/pari', [DashboardController::class, 'pari'])->name('dashboard.pari');
    Route::get('/score', [DashboardController::class, 'score'])->name('dashboard.score');
    Route::get('/participants', [DashboardController::class, 'participants'])->name('dashboard.participants');

    Route::post('/putBet', [DashboardController::class, 'putBet']);

    Route::middleware([isMembre::class])->group(function () {
        Route::get('/inscription', [DashboardController::class, 'inscription'])->name('dashboard.inscription');
        Route::get('/view_pari', [DashboardController::class, 'view_pari'])->name('dashboard.view_pari');

        Route::middleware([isCA::class])->group(function () {
            Route::get('/membres', [DashboardController::class, 'membres'])->name('dashboard.membres');
        });
    });
});
