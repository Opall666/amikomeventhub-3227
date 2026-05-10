<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // 1. Tampilkan daftar kategori
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    // 2. Tampilkan form tambah kategori
    public function create()
    {
        return view('admin.categories.create');
    }

    // 3. Simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
            ]);
        

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan! 🎉');
    }

    // 4. Tampilkan form edit kategori
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // 5. Update kategori
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update(['name' => $request->name,
                            'slug' => Str::slug($request->name)
                            ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diupdate! ✨');
    }

    // 6. Hapus kategori
    public function destroy(Category $category)
    {
        // Cek apakah kategori masih dipakai event
        if ($category->events()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Gagal hapus! Kategori ini masih digunakan oleh event.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus! 🗑️');
    }
}