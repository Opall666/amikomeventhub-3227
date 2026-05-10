@extends('admin.layout')
@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <!-- Header & Tombol Tambah -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800">Kelola Kategori</h1>
            <p class="text-slate-500 mt-1">Tambah dan atur kategori event Anda.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" 
           class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
            + Tambah Kategori
        </a>
    </div>

    <!-- Alert -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Nama Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Jumlah Event</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Dibuat</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                {{-- ✅ LOOP HARUS DIMULAI DI SINI --}}
                @forelse($categories as $category)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 font-bold text-slate-700">{{ $category->name }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $category->events->count() }} event</td>
                    <td class="px-6 py-4 text-slate-500 text-sm">{{ $category->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" 
                           class="px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 text-sm font-bold">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline"
                              onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 text-sm font-bold">Hapus</button>
                        </form>
                    </td>
                </tr>
                {{-- ✅ LOOP BERAKHIR DI SINI --}}
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-500">Belum ada kategori.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection