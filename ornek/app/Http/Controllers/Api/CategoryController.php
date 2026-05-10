<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str; // Slug oluşturmak için bu sınıfı dahil etmeliyiz!

class CategoryController extends Controller
{
    /**
     * KATEGORİ OLUŞTUR (admin gerekli)
     *
     * POST /api/categories
     * Body: { name }
     */
    public function store(Request $request)
    {
        // 1. Gelen veriyi doğrula (Boş olamaz, metin olmalı ve categories tablosunda benzersiz olmalı)
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

        // 4. İşlemin başarılı olduğunu gösteren JSON yanıtını döndür (201 Created)
        return response()->json([
            'message' => 'Kategori başarıyla oluşturuldu.',
            'category' => $category
        ], 201);
    }
}