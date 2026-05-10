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
            @method('PUT')

            <!-- Judul -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Judul Event <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $event->title) }}" required
                       class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none transition font-medium">
                @error('title') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- ✅ PENYELENGGARA -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Penyelenggara <span class="text-red-500">*</span></label>
                <input type="text" name="organizer" value="{{ old('organizer', $event->organizer) }}" required
                       class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none transition font-medium">
                @error('organizer') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Kategori & Tanggal (Grid 2 Kolom) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select name="category_id" required
                            class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none transition font-medium">
                        <option value="">Pilih Kategori...</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $event->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal & Waktu <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="date" value="{{ old('date', $event->date ? \Carbon\Carbon::parse($event->date)->format('Y-m-d\TH:i') : '') }}" required
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none transition font-medium">
                    @error('date') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Lokasi -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Tempat / Lokasi <span class="text-red-500">*</span></label>
                <input type="text" name="location" value="{{ old('location', $event->location) }}" required
                       class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none transition font-medium">
                @error('location') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- ✅ ALAMAT DETAIL -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Lengkap <span class="text-slate-400 font-normal">(Opsional)</span></label>
                <input type="text" name="location_detail" value="{{ old('location_detail', $event->location_detail) }}"
                       class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none transition font-medium">
                @error('location_detail') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Harga & Stok -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" value="{{ old('price', $event->price) }}" required
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none transition font-medium" min="0">
                    @error('price') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', $event->stock) }}" required
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none transition font-medium" min="1">
                    @error('stock') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Event <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" required
                          class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none transition font-medium resize-none">{{ old('description', $event->description) }}</textarea>
                @error('description') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- ✅ GUEST STAR / PEMBICARA -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Guest Star / Pembicara <span class="text-slate-400 font-normal">(Opsional)</span></label>
                <textarea name="guest_star" rows="3"
                          class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none transition font-medium resize-none">{{ old('guest_star', $event->guest_star) }}</textarea>
                @error('guest_star') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                <p class="text-xs text-slate-400 mt-1">Kosongkan jika event tidak memiliki narasumber/artis utama.</p>
            </div>

            <!-- Upload Poster -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Poster Event (Opsional)</label>
                <input type="file" name="poster" accept="image/*"
                       class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none transition font-medium">
                @if($event->poster_path)
                    <p class="text-xs text-slate-400 mt-1">Poster saat ini: <a href="{{ asset('storage/' . $event->poster_path) }}" target="_blank" class="text-indigo-600 hover:underline">Lihat</a></p>
                @endif
                @error('poster') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
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