<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;


// Admin Routes
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/admin/event', function () {
    return view('admin.event');
})->name('admin.event');

Route::get('/admin/transactions', function () {
    return view('admin.transactions');
})->name('admin.transactions');

// User Routes
Route::get('/', function () {
    return view('layouts.welcome');
})->name('welcome');

Route::get('/event-detail', function () {
    return view('layouts.event-detail');
})->name('layouts.event-detail');

Route::get('/checkout', function () {
    return view('layouts.checkout');
})->name('layouts.checkout');

Route::get('/ticket', function () {
    return view('layouts.ticket');
})->name('layouts.ticket');

// Halaman utama daftar event
Route::get('/events', [EventController::class, 'index'])->name('events.index');

// Detail satu event
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');