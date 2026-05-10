@extends('admin.layout')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-12">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-800">Edit Kategori</h1>
        <p class="text-slate-500 mt-1">Ubah nama kategori event.</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="name" class="block text-sm font-bold text-slate-700 mb-2">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name', $category->name) }}" 
                       placeholder="Contoh: Musik, Teknologi, Seni, Olahraga"
                       class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('name') border-red-500 @enderror"
                       required>
                @error('name')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
                <p class="text-slate-400 text-xs mt-2">Gunakan nama yang jelas dan mudah dipahami.</p>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                    Update Kategori
                </button>
                <a href="{{ route('admin.categories.index') }}" 
                   class="px-6 py-3 border-2 border-slate-200 text-slate-600 rounded-xl font-bold hover:border-slate-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection