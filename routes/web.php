<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResearchController;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Main Page / Dashboard
Route::get('/', [ResearchController::class, 'index'])->name('dashboard');

// CRUD Operations
Route::post('/research/store', [ResearchController::class, 'store'])->name('research.store');
Route::put('/research/update/{id}', [ResearchController::class, 'update'])->name('research.update');
Route::delete('/research/delete/{id}', [ResearchController::class, 'destroy'])->name('research.destroy');

/**
 * 🚨 MAGIC SETUP ROUTE (Para sa Render Free Tier)
 * Binisita ito sa browser para ma-migrate ang database at makagawa ng admin account.
 * Link: https://ict-research-system.onrender.com/setup-system
 */
Route::get('/setup-system', function () {
    try {
        // 1. Patakbuhin ang Migration (Force migrate dahil production sa Render)
        Artisan::call('migrate:fresh', ['--force' => true]);

        // 2. Gumawa ng Admin User para makapag-login ka
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        return "<h1>✅ System Setup Successful!</h1>
                <p>Tables have been created and the Admin account is ready.</p>
                <p><strong>Email:</strong> admin@gmail.com</p>
                <p><strong>Password:</strong> password123</p>
                <br>
                <a href='" . route('dashboard') . "' style='padding:10px 20px; background:indigo; color:white; text-decoration:none; border-radius:5px;'>Go to Dashboard & Login</a>";
                
    } catch (\Exception $e) {
        return "❌ Error during setup: " . $e->getMessage();
    }
});