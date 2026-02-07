<?php

use App\Http\Controllers\ResearchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Pag-open ng link, diretso Dashboard agad (No Login)
Route::get('/', [ResearchController::class, 'index'])->name('dashboard');

// Dashboard viewing, searching, and categories
Route::get('/dashboard', [ResearchController::class, 'index'])->name('dashboard');

// CRUD Routes: Para sa pag-save, pag-update, at pag-delete
Route::post('/research/store', [ResearchController::class, 'store'])->name('research.store');
Route::put('/research/update/{id}', [ResearchController::class, 'update'])->name('research.update');
Route::delete('/research/destroy/{id}', [ResearchController::class, 'destroy'])->name('research.destroy');

// THE MANUAL ARCHIVE ROUTE
Route::post('/research/archive/{id}', [ResearchController::class, 'archive'])->name('research.archive');

// SETUP ROUTE: Magic link para i-refresh ang database tables
Route::get('/setup-system', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', [
            '--force' => true,
        ]);
        return "✅ System Setup Successful! Tables created with 'is_archived' column.";
    } catch (\Exception $e) {
        return "❌ Error: " . $e->getMessage();
    }
});