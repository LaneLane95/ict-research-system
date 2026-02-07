<?php

use App\Http\Controllers\ResearchController;
use Illuminate\Support\Facades\Route;

// Main Dashboard and Filters
Route::get('/', [ResearchController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [ResearchController::class, 'index'])->name('dashboard');

// CRUD Operations
Route::post('/research/store', [ResearchController::class, 'store'])->name('research.store');
Route::put('/research/update/{id}', [ResearchController::class, 'update'])->name('research.update');
Route::delete('/research/destroy/{id}', [ResearchController::class, 'destroy'])->name('research.destroy');

// ARCHIVE ROUTE
Route::post('/research/archive/{id}', [ResearchController::class, 'archive'])->name('research.archive');