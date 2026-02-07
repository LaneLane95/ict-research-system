<?php

use App\Http\Controllers\ResearchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

Route::get('/', [ResearchController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [ResearchController::class, 'index'])->name('dashboard');

Route::post('/research/store', [ResearchController::class, 'store'])->name('research.store');
Route::put('/research/update/{id}', [ResearchController::class, 'update'])->name('research.update');
Route::delete('/research/destroy/{id}', [ResearchController::class, 'destroy'])->name('research.destroy');
Route::post('/research/archive/{id}', [ResearchController::class, 'archive'])->name('research.archive');

Route::get('/setup-system', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return "✅ BESH! Database updated successfully via Link!";
    } catch (\Exception $e) {
        return "❌ Error: " . $e->getMessage();
    }
});