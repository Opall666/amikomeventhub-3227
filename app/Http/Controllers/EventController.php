<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;


class EventController extends Controller
{
// Fungsi untuk menampilkan halaman utama dengan daftar event
    public function index()
    {
        // Ambil 6 event terbaru untuk homepage
        // Jika di halaman /events ingin menampilkan semua, bisa disesuaikan
        $events = Event::with('category')
            ->latest('date')
            ->take(6) 
            ->get();
        
        return view('layouts.welcome', compact('events'));
    }

// Fungsi untuk menampilkan detail event berdasarkan ID
    public function show($id)
    {
        // Ambil data event berdasarkan ID dari database
        $event = \App\Models\Event::with('category')->find($id);

        // Jika event tidak ditemukan, kembali ke halaman utama
        if (!$event) {
            return redirect('/');
        }

        // Kirim data ke view layouts.event-detail
        return view('layouts.event-detail', compact('event'));
    }

// Fungsi untuk menampilkan halaman checkout dengan data event
    public function checkout($id)
    {
        // Ambil data event berdasarkan ID
        $event = \App\Models\Event::find($id);

        // Jika event tidak ada, kembali ke home
        if (!$event) {
            return redirect('/');
        }

        // Kirim data ke view checkout
        return view('layouts.checkout', compact('event'));
    }

// Fungsi untuk memproses checkout (POST)
    public function processCheckout(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
        ]);

        // 2. Ambil data event
        $event = Event::find($validated['event_id']);

        // 3. Cek stok
        if ($event->stock < 1) {
            return redirect()->back()->with('error', 'Maaf, tiket sudah habis!');
        }

        // 4. Buat Order ID unik
        $orderId = 'TRX-' . time() . '-' . rand(1000, 9999);

        // 5. Simpan ke tabel transactions
        $transaction = Transaction::create([
            'event_id' => $event->id,
            'order_id' => $orderId,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'total_price' => $event->price + 5000, // harga tiket + biaya layanan
            'status' => 'Pending',
        ]);

        // 6. Kurangi stok event
        $event->decrement('stock');

        // 7. Redirect ke halaman ticket/sukses
        // Simpan ke session
        session(['last_transaction' => $transaction, 'last_event' => $event]);

        // Redirect
        return redirect()->route('ticket.success', $transaction->id);
        }
}
