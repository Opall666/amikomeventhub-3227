@extends('admin.layout')

@section('content')
<div class="flex-1 p-10 overflow-y-auto">
    <header class="mb-10">
        <h1 class="text-3xl font-black">Edit Event</h1>
        <p class="text-slate-500 font-medium">Ubah detail acara yang sudah ada.</p>
    </header>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8 max-w-3xl">
        <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- PENTING: Method untuk UPDATE -->

            <!-- Judul -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Judul Event</label>
                <input type="text" name="title" value="{{ old('title', $event->title) }}" 
                       class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none transition font-medium">
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Kategori -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Kategori</label>
                <select name="category_id" class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none transition font-medium">
                    <option value="">Pilih Kategori...</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $event->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Deskripsi -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="4" 
                          class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none transition font-medium">{{ old('description', $event->description) }}</textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Tanggal & Lokasi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal & Waktu</label>
                    <input type="datetime-local" name="date" value="{{ old('date', $event->date?->format('Y-m-d\TH:i')) }}" 
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none transition font-medium">
                    @error('date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Lokasi</label>
                    <input type="text" name="location" value="{{ old('location', $event->location) }}" 
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none transition font-medium">
                    @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Harga & Stok -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', $event->price) }}" 
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none transition font-medium" min="0">
                    @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', $event->stock) }}" 
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none transition font-medium" min="1">
                    @error('stock') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Upload Poster -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Poster Event (Opsional)</label>
                <input type="file" name="poster" accept="image/*" 
                       class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none transition font-medium">
                @if($event->poster_path)
                    <p class="text-xs text-slate-400 mt-1">Poster saat ini: <a href="{{ asset('storage/' . $event->poster_path) }}" target="_blank" class="text-indigo-600 hover:underline">Lihat</a></p>
                @endif
                @error('poster') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Tombol -->
            <div class="flex justify-end gap-4 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.events.index') }}" class="px-8 py-4 text-slate-500 font-bold hover:text-slate-800 transition rounded-2xl hover:bg-slate-50">Batal</a>
                <button type="submit" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection