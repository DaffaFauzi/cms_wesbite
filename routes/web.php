<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;

/*
|--------------------------------------------------------------------------
| Public Frontend
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/site/{company}', [FrontendController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Authenticated + Tenant Protected
|--------------------------------------------------------------------------
| Admin requires company session (enforced by TenantMiddleware).
| Super Admin bypasses tenant check.
*/
Route::middleware(['auth', 'tenant'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pages
    Route::resource('pages', PageController::class);

    // Sections (nested under pages)
    Route::resource('pages.sections', \App\Http\Controllers\SectionController::class);

    // Media
    Route::resource('media', MediaController::class)->only(['index', 'store', 'destroy']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Super Admin Only
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:super_admin'])->group(function () {

    // Companies
    Route::resource('companies', CompanyController::class);

    Route::get('/super-admin', function () {
        return 'Super Admin Only';
    })->name('super-admin');
});

require __DIR__ . '/auth.php';