<?php

use App\Http\Controllers\ResearchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

// Main Dashboard
Route::get('/', [ResearchController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [ResearchController::class, 'index'])->name('dashboard');

// CRUD Operations
Route::post('/research/store', [ResearchController::class, 'store'])->name('research.store');
Route::put('/research/update/{id}', [ResearchController::class, 'update'])->name('research.update');
Route::delete('/research/destroy/{id}', [ResearchController::class, 'destroy'])->name('research.destroy');
Route::post('/research/archive/{id}', [ResearchController::class, 'archive'])->name('research.archive');

// THE ULTIMATE RESET ROUTE (Fixes SQLite File Locking)
Route::get('/setup-system', function () {
    try {
        $dbPath = database_path('database.sqlite');
        
        // Burahin ang lumang file para mawala ang lumang table structures
        if (File::exists($dbPath)) {
            File::delete($dbPath);
        }
        
        // Gumawa ng bagong blangkong database file
        File::put($dbPath, '');
        chmod($dbPath, 0666);

        // Patakbuhin ang migration mula sa simula
        Artisan::call('migrate:fresh', [
            '--force' => true,
        ]);
        
        return "✅ BESH! MALINIS NA ANG DATABASE! May 'is_archived' na ang database mo. Try mo na mag-add!";
    } catch (\Exception $e) {
        return "❌ Error: " . $e->getMessage();
    }
});