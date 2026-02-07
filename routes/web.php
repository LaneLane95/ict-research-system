<?php

use App\Http\Controllers\ResearchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Dashboard Routes (No Login)
Route::get('/', [ResearchController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [ResearchController::class, 'index'])->name('dashboard');

// 2. CRUD Operations
Route::post('/research/store', [ResearchController::class, 'store'])->name('research.store');
Route::put('/research/update/{id}', [ResearchController::class, 'update'])->name('research.update');
Route::delete('/research/destroy/{id}', [ResearchController::class, 'destroy'])->name('research.destroy');

// 3. Manual Archive Operation
Route::post('/research/archive/{id}', [ResearchController::class, 'archive'])->name('research.archive');

// 4. THE ULTIMATE RESET ROUTE (Fixes "no column named is_archived")
Route::get('/setup-system', function () {
    try {
        $dbPath = database_path('database.sqlite');

        // Step A: Piliting burahin ang lumang database file para mawala ang lumang table
        if (File::exists($dbPath)) {
            File::delete($dbPath);
        }

        // Step B: Gumawa ng bagong blangkong file
        File::put($dbPath, '');
        chmod($dbPath, 0666);

        // Step C: Patakbuhin ang migration mula sa simula
        Artisan::call('migrate:fresh', [
            '--force' => true,
        ]);
        
        return "✅ DATABASE RECONSTRUCTED! Ang table mo ay bago na at may 'is_archived' column na. Try mo na mag-add, Besh!";
    } catch (\Exception $e) {
        return "❌ Error: " . $e->getMessage();
    }
});