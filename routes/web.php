<?php

use App\Http\Controllers\ClubMatchResult;
use App\Http\Controllers\MatchController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\KlubController;
use App\Http\Controllers\SkorController;

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



Route::post('/add-club', [ClubMatchResult::class, 'addClub'])->name('addClub');
Route::get('/index', [ClubMatchResult::class, 'index'])->name('index');
Route::get('/match', [MatchController::class, 'index'])->name('match');
Route::post('/add-match-result', [MatchController::class, 'addMatchResult'])->name('addMatchResult');



Route::get('/klub', [KlubController::class, 'index'])->name('klub.index');
Route::post('/klub', [KlubController::class, 'store'])->name('klub.store');
Route::get('/skor', [SkorController::class, 'index'])->name('skor.index');
Route::post('/skor', [SkorController::class, 'store'])->name('skor.store');
Route::post('/skor/multiple', [SkorController::class, 'storeMultiple'])->name('skor.storeMultiple');
Route::get('/', [SkorController::class, 'klasemen'])->name('klasemen');




