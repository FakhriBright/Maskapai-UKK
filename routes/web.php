<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Customer;
use App\Http\Controllers\Staff;
use App\Http\Controllers\Manager;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', function () {
    $airports = \App\Models\Airport::orderBy('city')->get();
    return view('welcome', compact('airports'));
})->name('home');

// Global Dashboard Redirect Route
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified', 'role.redirect'])->name('dashboard');

// Profile Routes (Bawaan Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* ==========================================================================
   ADMIN ROUTES (CRUD Master Data)
   ========================================================================== */
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('airlines', Admin\AirlineController::class)->except(['show']);
    Route::resource('airports', Admin\AirportController::class)->except(['show']);
    Route::resource('airplanes', Admin\AirplaneController::class)->except(['show']);
    Route::resource('flights', Admin\FlightController::class)->except(['show']);
    
    Route::resource('users', Admin\UserController::class)->except(['show', 'destroy']);
    Route::delete('/users/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/deactivate', [Admin\UserController::class, 'deactivate'])->name('users.deactivate');
    Route::post('/users/{userId}/activate', [Admin\UserController::class, 'activate'])->name('users.activate');
});

/* ==========================================================================
   CUSTOMER ROUTES (Portal Pemesanan)
   ========================================================================== */
Route::middleware(['auth', 'verified', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [Customer\DashboardController::class, 'index'])->name('dashboard');
    
    // Booking Flow
    Route::get('/booking/{flight}', [Customer\BookingController::class, 'show'])->name('booking.show');
    Route::post('/booking/{flight}', [Customer\BookingController::class, 'store'])->name('booking.store');
    
    // Payment
    Route::get('/pay/{booking}', [Customer\PaymentController::class, 'show'])->name('pay');
    Route::post('/pay/{booking}/simulate', [Customer\PaymentController::class, 'simulate'])->name('pay.simulate');
    
    // History & Ticket
    Route::get('/history', [Customer\TicketController::class, 'history'])->name('history');
    Route::get('/ticket/{booking}', [Customer\TicketController::class, 'show'])->name('ticket.show');
    Route::get('/ticket/{booking}/download', [Customer\TicketController::class, 'download'])->name('ticket.download');
});

/* ==========================================================================
   STAFF ROUTES (Operasional & Check-in)
   ========================================================================== */
Route::middleware(['auth', 'verified', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [Staff\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/flights/{flight}/manifest', [Staff\DashboardController::class, 'manifest'])->name('flights.manifest');
    Route::get('/flights/{flight}/checkin', [Staff\CheckinController::class, 'flight'])->name('flights.checkin');
    
    Route::get('/checkin/{booking}', [Staff\CheckinController::class, 'show'])->name('checkin.show');
    Route::post('/checkin/{booking}', [Staff\CheckinController::class, 'process'])->name('checkin.process');
});

/* ==========================================================================
   MANAGER ROUTES (Laporan & Analitik)
   ========================================================================== */
Route::middleware(['auth', 'verified', 'role:manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [Manager\DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/report', [Manager\ReportController::class, 'index'])->name('report.index');
    Route::get('/report/export-pdf', [Manager\ReportController::class, 'exportPdf'])->name('report.exportPdf');
});

/* ==========================================================================
   WEBHOOK & PUBLIC ROUTES
   ========================================================================== */
// Midtrans Webhook (Tanpa CSRF & Auth)
Route::post('/payment/notification', [Customer\PaymentController::class, 'handleWebhook'])->name('payment.webhook');

// Auth Routes (Breeze)
require __DIR__.'/auth.php';
