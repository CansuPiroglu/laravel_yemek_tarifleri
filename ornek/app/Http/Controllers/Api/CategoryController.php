<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Slug işlemi için gerekli

class CategoryController extends Controller
{
    // ── MOBİL İÇİN KATEGORİLERİ GETİR (Bizim eklediğimiz) ──
    public function index()
    {
        $categories = Category::all();

        return response()->json($categories, 200);
    }

    // ── YENİ KATEGORİ OLUŞTUR (Senin önceden yazdığın) ──
    public function store(Request $request)
    {
        // 1. Gelen veriyi doğrula
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        // 2. Slug oluştur (Örn: "Tatlı Tarifleri" -> "tatli-tarifleri")
        $slug = Str::slug($request->name);

        // 3. Kategoriyi veritabanına kaydet
        $category = Category::create([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        // 4. İşlemin başarılı olduğunu gösteren JSON yanıtını döndür
        return response()->json([
            'message' => 'Kategori başarıyla oluşturuldu.',
            'category' => $category
        ], 201);
    }
}
