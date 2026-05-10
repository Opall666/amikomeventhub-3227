@extends('admin.layout')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-800">Tambah Kategori Baru</h1>
        <p class="text-slate-500 mt-1">Buat kategori untuk mengelompokkan event.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Musik, Teknologi, Seni"
                       class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 @error('name') border-red-500 @enderror" required>
                @error('name') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
            </div>
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700">Simpan</button>
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 border border-slate-200 rounded-xl font-bold hover:bg-slate-50">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection