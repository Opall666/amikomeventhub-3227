<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
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
        // 1. Validasi Input
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
        ]);

        $event = \App\Models\Event::find($validated['event_id']);

        if ($event->stock < 1) {
            return redirect()->back()->with('error', 'Maaf, stok tiket sudah habis!');
        }

        // 2. Gunakan Database Transaction (Aman & Konsisten)
        DB::beginTransaction();
        try {
            $orderId = 'TRX-' . time() . '-' . rand(1000, 9999);

            // Simpan transaksi DULUAN
            $transaction = \App\Models\Transaction::create([
                'event_id' => $event->id,
                'order_id' => $orderId,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'total_price' => $event->price + 5000,
                'status' => 'Pending',
            ]);

            // Baru kurangi stok
            $event->decrement('stock');

            // Commit semua perubahan
            DB::commit();

            // Redirect ke halaman sukses
            return redirect()->route('ticket.success')->with([
                'transaction' => $transaction,
                'event' => $event,
            ]);

        } catch (\Exception $e) {
            // Jika gagal, batalkan semua (stok tidak berkurang, data tidak masuk)
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }
}
