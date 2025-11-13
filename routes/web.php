<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Plwd\ProfileController;
use App\Http\Controllers\OpportunityController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Opportunities route (requires authentication)
Route::get('/opportunities', [OpportunityController::class, 'index'])->name('opportunities.index');

// Authentication routes (will be added by Breeze)
require __DIR__.'/auth.php';

// Dashboard redirect based on role
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('plwd.dashboard');
})->middleware(['auth'])->name('dashboard');

// PLWD routes
Route::middleware(['auth', 'verified', 'role:plwd'])->prefix('plwd')->name('plwd.')->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'index'])->name('dashboard');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/documents/upload', [ProfileController::class, 'uploadDocument'])->name('documents.upload');
    Route::delete('/documents/{id}', [ProfileController::class, 'deleteDocument'])->name('documents.delete');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // User Management (all registered users)
    Route::get('/users', [AdminController::class, 'listUsers'])->name('users.index');
    
    // PLWD Management
    Route::get('/plwds', [AdminController::class, 'listPlwds'])->name('plwds.index');
    Route::get('/plwds/{id}', [AdminController::class, 'show'])->name('plwds.show');
    Route::post('/plwds/{id}/approve', [AdminController::class, 'approve'])->name('plwds.approve');
    Route::post('/plwds/{id}/reject', [AdminController::class, 'reject'])->name('plwds.reject');
    Route::delete('/plwds/{id}', [AdminController::class, 'destroy'])->name('plwds.destroy');
    
    // Reports & Exports
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/export/excel', [AdminController::class, 'exportExcel'])->name('export.excel');
    Route::get('/export/pdf', [AdminController::class, 'exportPdf'])->name('export.pdf');
    
    // Audit Logs
    Route::get('/audit-logs', [AdminController::class, 'auditLogs'])->name('audit-logs');
    
    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    
    // Metadata Management
    Route::get('/disability-types', [AdminController::class, 'manageDisabilityTypes'])->name('disability-types');
    Route::post('/disability-types', [AdminController::class, 'storeDisabilityType'])->name('disability-types.store');
    Route::put('/disability-types/{id}', [AdminController::class, 'updateDisabilityType'])->name('disability-types.update');
    Route::delete('/disability-types/{id}', [AdminController::class, 'destroyDisabilityType'])->name('disability-types.destroy');
    
    Route::get('/education-levels', [AdminController::class, 'manageEducationLevels'])->name('education-levels');
    Route::post('/education-levels', [AdminController::class, 'storeEducationLevel'])->name('education-levels.store');
    Route::put('/education-levels/{id}', [AdminController::class, 'updateEducationLevel'])->name('education-levels.update');
    Route::delete('/education-levels/{id}', [AdminController::class, 'destroyEducationLevel'])->name('education-levels.destroy');
    
    Route::get('/skills', [AdminController::class, 'manageSkills'])->name('skills');
    Route::post('/skills', [AdminController::class, 'storeSkill'])->name('skills.store');
    Route::put('/skills/{id}', [AdminController::class, 'updateSkill'])->name('skills.update');
    Route::delete('/skills/{id}', [AdminController::class, 'destroySkill'])->name('skills.destroy');
});

