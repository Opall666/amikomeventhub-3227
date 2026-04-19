<?php

use Illuminate\Support\Facades\Route;

// Admin Routes
Route::get('/dashboard', function () {
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

