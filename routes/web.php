<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Main Dashboard - ISA LANG DAPAT ANG MAY NAME NA DASHBOARD
Route::get('/', [ResearchController::class, 'index'])->name('dashboard');

// CRUD Operations
Route::post('/research/store', [ResearchController::class, 'store'])->name('research.store');
Route::put('/research/update/{id}', [ResearchController::class, 'update'])->name('research.update');
Route::delete('/research/destroy/{id}', [ResearchController::class, 'destroy'])->name('research.destroy');

// Archive Route
Route::post('/research/archive/{id}', [ResearchController::class, 'archive'])->name('research.archive');