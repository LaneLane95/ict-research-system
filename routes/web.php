<?php

use App\Http\Controllers\ResearchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// 1. Main Dashboard (No Login)
Route::get('/', [ResearchController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [ResearchController::class, 'index'])->name('dashboard');

// 2. CRUD Routes
Route::post('/research/store', [ResearchController::class, 'store'])->name('research.store');
Route::put('/research/update/{id}', [ResearchController::class, 'update'])->name('research.update');
Route::delete('/research/destroy/{id}', [ResearchController::class, 'destroy'])->name('research.destroy');

// 3. Manual Archive Route
Route::post('/research/archive/{id}', [ResearchController::class, 'archive'])->name('research.archive');

// 4. THE MAGIC SETUP ROUTE (Full Code)
Route::get('/setup-system', function () {
    try {
        // Buburahin ang luma at gagawa ng bago base sa updated Migration file mo
        Artisan::call('migrate:fresh', [
            '--force' => true,
        ]);
        
        return "✅ System Setup Successful! Ang database mo ay updated na at may 'is_archived' column na. Pwede ka na mag-add ng records, Besh!";
    } catch (\Exception $e) {
        return "❌ Error: " . $e->getMessage();
    }
});