<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminController;

// Public routes
Route::get('/', function () {
    return redirect('/login'); // redirect root ke /login
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login'); // route GET untuk menampilkan form login

Route::post('/login', [AuthController::class, 'login'])->name('login.process'); // tambahkan nama untuk POST login
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Protected routes
Route::middleware(['auth'])->group(function () {
    // Karyawan routes
    Route::middleware(['role:karyawan'])->prefix('karyawan')->name('karyawan.')->group(function () {
        Route::get('/dashboard', function () {
            return view('karyawan.dashboard');
        })->name('dashboard');

        Route::resource('tickets', TicketController::class);
    });

    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/tickets', [AdminController::class, 'ticketsIndex'])->name('tickets.index');
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
        Route::get('/reports/companies', [AdminController::class, 'companyReports'])->name('reports.companies');
    });
});
