<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    /**
     * Tampilkan homepage dengan daftar event terbaru
     */
    public function index()
    {
        $events = Event::with('category')
            ->latest()  
            ->paginate(6);  

        if (request()->ajax()) {
            return response()->json([
                'html' => view('partials.event-card', compact('events'))->render(),
                'next_page' => $events->nextPageUrl(),
            ]);
        }

        return view('layouts.welcome', compact('events'));
    }

    /**
     * Tampilkan detail event berdasarkan ID
     */
    public function show(Event $event)
    {
        // Route Model Binding: Laravel otomatis fetch event by ID
        // Jika tidak ditemukan, otomatis 404 (atau bisa handle manual)
        
        $event->load('category');

        return view('layouts.event-detail', compact('event'));
    }

    /**
     * Tampilkan halaman checkout untuk event tertentu
     */
    public function checkout(Event $event)
    {
        return view('layouts.checkout', compact('event'));
    }

    /**
     * Proses checkout & simpan transaksi ke database
     */
    public function processCheckout(Request $request)
    {
        // 1. Validasi input user
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
        ], [
            // Custom error messages (opsional, biar lebih user-friendly)
            'event_id.required' => 'Event tidak ditemukan.',
            'customer_name.required' => 'Nama lengkap wajib diisi.',
            'customer_email.required' => 'Email wajib diisi.',
            'customer_email.email' => 'Format email tidak valid.',
            'customer_phone.required' => 'Nomor WhatsApp wajib diisi.',
        ]);

        // 2. Ambil data event
        $event = Event::find($validated['event_id']);

        // 3. Validasi stok
        if (!$event || $event->stock < 1) {
            return redirect()->route('events.show', $event?->id)
                ->with('error', 'Maaf, stok tiket untuk event ini sudah habis! 🎫');
        }

        // 4. Atomic Database Transaction (Semua berhasil atau semua batal)
        DB::beginTransaction();

        try {
            // Generate Order ID unik
            $orderId = 'TRX-' . time() . '-' . rand(1000, 9999);

            // 5. Simpan data transaksi
            $transaction = Transaction::create([
                'event_id' => $event->id,
                'order_id' => $orderId,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'total_price' => $event->price + 5000, // harga tiket + biaya layanan
                'status' => 'Pending',
            ]);

            // 6. Kurangi stok event (hanya jika transaksi berhasil)
            $event->decrement('stock');

            // 7. Commit semua perubahan ke database
            DB::commit();

            // 8. Simpan ke session untuk halaman ticket (fallback)
            session([
                'last_transaction' => $transaction,
                'last_event' => $event,
            ]);

            // 9. Redirect ke halaman sukses dengan ID transaksi
            return redirect()->route('ticket.success', $transaction->id);

        } catch (\Exception $e) {
            // Jika ada error, rollback semua (stok tidak berkurang, data tidak masuk)
            DB::rollBack();

            // Catat error ke log server (bisa dicek di tab Logs Laravel Cloud)
            Log::error('Checkout Failed: ' . $e->getMessage(), [
                'event_id' => $event->id,
                'customer_email' => $validated['customer_email'] ?? null,
                'trace' => $e->getTraceAsString(),
            ]);

            // Redirect kembali dengan pesan error yang aman untuk user
            return redirect()->route('events.show', $event->id)
                ->with('error', 'Gagal memproses pesanan. Silakan coba lagi atau hubungi admin.');
        }
    }
}