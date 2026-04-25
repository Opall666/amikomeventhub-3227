<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES - AmikomEventHub
|--------------------------------------------------------------------------
| 
| Struktur Route:
| 1. Public/User Routes (Customer Flow)
| 2. Admin Routes (Management)
| 3. Development/Testing Routes (Opsional)
|
*/

// ============================================================================
// 🎫 PUBLIC / USER ROUTES (Customer Flow)
// ============================================================================

// 1. Homepage & Listing
// ---------------------------------------------------------------------------
Route::get('/', [EventController::class, 'index'])->name('welcome');
Route::get('/events', [EventController::class, 'index'])->name('events.index');

// 2. Event Details & Booking Flow
// ---------------------------------------------------------------------------
// Detail event (Dynamic - Route Model Binding)
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Checkout: Tampilkan form (GET) - Menerima ID event
Route::get('/checkout/{event}', [EventController::class, 'checkout'])->name('checkout.form');

// Checkout: Proses pembayaran (POST)
Route::post('/checkout/process', [EventController::class, 'processCheckout'])->name('checkout.process');

// Ticket: Halaman sukses setelah checkout
// Menerima optional transaction ID, fallback ke session
Route::get('/ticket/{transaction?}', function ($transactionId = null) {
    if ($transactionId) {
        $transaction = \App\Models\Transaction::with('event')->find($transactionId);
        $event = $transaction?->event;
    } else {
        // Fallback dari session (jika akses langsung /ticket)
        $transaction = session('last_transaction');
        $event = session('last_event');
    }
    
    // Jika data tidak ada, redirect ke home
    if (!$event) {
        return redirect('/');
    }
    
    return view('layouts.ticket', compact('transaction', 'event'));
})->name('ticket.success');


// ============================================================================
// 👨‍💼 ADMIN ROUTES (Management Dashboard)
// ============================================================================
// Note: Nanti tambahkan middleware 'auth' dan 'admin' untuk proteksi

Route::prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Manage Events (CRUD will be implemented later)
    Route::get('/events', function () {
        return view('admin.event');
    })->name('events');
    
    // Manage Transactions
    Route::get('/transactions', function () {
        return view('admin.transactions');
    })->name('transactions');
    
});

// ============================================================================
// 🔧 DEVELOPMENT / TESTING (Opsional - Hapus saat Production)
// ============================================================================
/*
Route::get('/test', function () {
    return view('layouts.welcome');
});
*/