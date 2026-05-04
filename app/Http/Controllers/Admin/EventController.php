<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua event dengan relasi category, urutkan dari yang terbaru, paginate 10 per halaman
        $events = \App\Models\Event::with('category')->latest()->paginate(10);
        
        // Return view ke: resources/views/admin/events/index.blade.php
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua kategori untuk dropdown di form
        $categories = \App\Models\Category::all();
        
        // Tampilkan View crate
        return view('admin.events.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'poster_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
        // Handle Upload Gambar
        if ($request->hasFile('poster')) {
            // Simpan ke folder public/images
            $imagePath = $request->file('poster')->store('images', 'public');
            $validated['poster_path'] = $imagePath;
        }   

        // 2. Simpan data ke database
            \App\Models\Event::create($validated);

        // 3. Redirect kembali ke halaman list dengan pesan sukses
            return redirect()->route('admin.events.index')
                ->with('success', 'Event berhasil ditambahkan! 🎉');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\Event $event)
    {
        $categories = \App\Models\Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\Illuminate\Http\Request $request, \App\Models\Event $event)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'date'        => 'required|date',
            'location'    => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|numeric|min:1',
            'category_id' => 'required|exists:categories,id',
            'poster'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle upload gambar baru (jika ada)
        if ($request->hasFile('poster')) {
            // Hapus gambar lama jika ada
            if ($event->poster_path && file_exists(storage_path('app/public/' . $event->poster_path))) {
                unlink(storage_path('app/public/' . $event->poster_path));
            }
            $validated['poster_path'] = $request->file('poster')->store('images', 'public');
        }

        // Update data
        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Data event berhasil diperbarui! ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Event $event)
    {
        // Hapus file poster jika ada
        if ($event->poster_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($event->poster_path);
        }
        
        // Hapus data event dari database
        $event->delete();
        
        // Redirect kembali dengan pesan sukses
        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus! 🗑️');
    }
}
