<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BetController;
use App\Http\Controllers\EcurieController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SponsorController;

use App\Http\Middleware\isMembre;
use App\Http\Middleware\isOrga;
use App\Http\Middleware\isCA;
use App\Http\Middleware\checkProfile;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [MemberController::class, 'profile'])->name('dashboard.profile');
    Route::post('/editProfile', [MemberController::class, 'editProfile']);
});

Route::middleware(['auth', checkProfile::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'home'])->name('dashboard.home');
    Route::get('/pari', [BetController::class, 'pari'])->name('dashboard.pari');
    Route::get('/score', [DashboardController::class, 'score'])->name('dashboard.score');
    Route::get('/participants', [DashboardController::class, 'participants'])->name('dashboard.participants');

    Route::get('/join/{token}', [MemberController::class, 'join']);
    Route::get('/inscrire/{token}', [InscriptionController::class, 'inscrire']);

    Route::post('/putBet', [BetController::class, 'putBet']);

    Route::middleware([isMembre::class])->group(function () {
        Route::get('/view_pari', [BetController::class, 'view_pari'])->name('dashboard.view_pari');

        Route::middleware([isOrga::class])->group(function () {
            Route::get('/inscription', [InscriptionController::class, 'inscription'])->name('dashboard.inscription');
            Route::get('/editPilote/{id}', [InscriptionController::class, 'editPilote']);
            Route::post('/addPilote', [InscriptionController::class, 'addPilote']);
            Route::post('/editPilote/{id}', [InscriptionController::class, 'editPilotePost']);
            Route::get('/deletePilote/{id}', [InscriptionController::class, 'deletePilote']);

            Route::get('/sponsor', [SponsorController::class, 'sponsor'])->name('dashboard.sponsor');
            Route::get('/editSponsor/{id}', [SponsorController::class, 'editSponsor']);
            Route::post('/createSponsor', [SponsorController::class, 'createSponsor']);
            Route::post('/editSponsor/{id}', [SponsorController::class, 'editSponsorPost']);
            Route::get('/deleteSponsor/{id}', [SponsorController::class, 'deleteSponsor']);

            Route::get('/ecurie', [EcurieController::class, 'ecurie'])->name('dashboard.ecurie');
            Route::get('/editEcurie/{id}', [EcurieController::class, 'editEcurie']);
            Route::post('/createEcurie', [EcurieController::class, 'createEcurie']);
            Route::post('/editEcurie/{id}', [EcurieController::class, 'editEcuriePost']);
            Route::get('/deleteEcurie/{id}', [EcurieController::class, 'deleteEcurie']);

            Route::get('/validateBet/{BetID}', [BetController::class, 'validateBet']);


            Route::middleware([isCA::class])->group(function () {
                Route::get('/membres', [MemberController::class, 'membres'])->name('dashboard.membres');
                Route::get('/editMember/{id}', [MemberController::class, 'editMember']);
                Route::post('/addMember', [MemberController::class, 'addMember']);
                Route::post('/editMember/{id}', [MemberController::class, 'editMemberPost']);
                Route::get('/deleteMember/{id}', [MemberController::class, 'deleteMember']);

                Route::get('/result', [DashboardController::class, 'result'])->name('dashboard.result');
                Route::post('/setResult', [DashboardController::class, 'setResult']);
            });
        });
    });
});
