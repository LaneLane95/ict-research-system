<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResearchController;

// Main Page
Route::get('/', [ResearchController::class, 'index'])->name('dashboard');

// CRUD Operations
Route::post('/research/store', [ResearchController::class, 'store'])->name('research.store');

// Ginawa nating PUT para mag-match sa form nating may @method('PUT')
Route::put('/research/update/{id}', [ResearchController::class, 'update'])->name('research.update');

Route::delete('/research/delete/{id}', [ResearchController::class, 'destroy'])->name('research.destroy');