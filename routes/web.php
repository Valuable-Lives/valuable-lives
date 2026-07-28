<?php

use App\Http\Controllers\HoldingController;
use App\Http\Controllers\IndividualController;
use App\Http\Controllers\ParishController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/search', SearchController::class)->name('search');

    Route::get('/individuals', [IndividualController::class, 'index'])->name('individuals.index');
    Route::get('/individuals/{individual}', [IndividualController::class, 'show'])->name('individuals.show');

    Route::get('/holdings', [HoldingController::class, 'index'])->name('holdings.index');
    Route::get('/holdings/{holding}', [HoldingController::class, 'show'])->name('holdings.show');

    Route::get('/parishes', [ParishController::class, 'index'])->name('parishes.index');
    Route::get('/parishes/{parish}', [ParishController::class, 'show'])->name('parishes.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
