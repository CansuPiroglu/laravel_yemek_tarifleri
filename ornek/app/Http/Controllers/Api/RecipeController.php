<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\RecipeStep;
use Illuminate\Support\Str;

class RecipeController extends Controller
{
    /**
     * TARİF LİSTESİ (Sayfalamalı ve Filtreli)
     *
     * GET /api/recipes?page=1&category_id=2&search=köfte
     */
    public function index(Request $request)
    {
        // 1. Sorguyu başlat ve ilişkileri (user, category) yükle (Performans için Eager Loading)
        $query = Recipe::with(['user', 'category']);

        // Sadece onaylanmış tarifleri listelemek istersen bu satırı açabilirsin:
        // $query->where('status', 'approved');

        // 2. Kategori filtresi varsa uygula
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 3. Arama (search) kelimesi varsa uygula
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // 4. Laravel'in paginate() metodu hocanın istediği "data" ve "meta" JSON yapısını otomatik kurar
        $recipes = $query->paginate(10);

        return response()->json($recipes, 200);
    }

    /**
     * TEK TARİF (Detay Sayfası)
     *
     * GET /api/recipes/{id}
     */
    public function show(int $id)
    {
        // Hocanın tam istediği gibi: findOrFail ile bul, ilişkilerin tamamını çek.
        $recipe = Recipe::with(['user', 'category', 'ingredients', 'steps', 'reviews.user'])->findOrFail($id);
        
        return response()->json($recipe, 200);
    }

    /**
     * TARİF OLUŞTUR (auth gerekli) — FAZ 2
     *
     * POST /api/recipes
     */
    public function store(Request $request)
    {
        // 1. Gelen tüm verileri titizlikle doğrula
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'prep_time' => 'nullable|integer',
            'cook_time' => 'nullable|integer',
            'servings' => 'nullable|integer',
            'image' => 'nullable|image|max:2048', // Maksimum 2MB resim
            'ingredients' => 'required|array',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'nullable|string',
            'ingredients.*.unit' => 'nullable|string',
            'steps' => 'required|array',
            'steps.*' => 'required|string',
        ]);

        // 2. Başlıktan eşsiz (unique) bir slug oluştur
        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $counter = 1;
        // Eğer aynı isimde tarif varsa sonuna -1, -2 ekleyerek benzersiz yap
        while (Recipe::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // 6. Fotoğraf Yükleme İşlemi
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('recipes', 'public');
        }

        // 3. Tarifi veritabanına kaydet
        $recipe = Recipe::create([
            'user_id' => $request->user()->id, // İsteği yapan kişinin ID'si
            'category_id' => $validatedData['category_id'],
            'title' => $validatedData['title'],
            'slug' => $slug,
            'description' => $validatedData['description'] ?? null,
            'prep_time' => $validatedData['prep_time'] ?? null,
            'cook_time' => $validatedData['cook_time'] ?? null,
            'servings' => $validatedData['servings'] ?? null,
            'image_url' => $imagePath, // Veritabanındaki sütun adına göre ayarladık
            'status' => 'pending', // İlk yüklendiğinde admin onayı beklesin
        ]);

        // 4. Malzemeleri Ara Tabloya (Pivot) Bağla
        $ingredientsPivotData = [];
        foreach ($request->ingredients as $ingredient) {
            $ingredientsPivotData[$ingredient['id']] = [
                'quantity' => $ingredient['quantity'] ?? null,
                'unit' => $ingredient['unit'] ?? null,
            ];
        }
        $recipe->ingredients()->attach($ingredientsPivotData);

        // 5. Hazırlanış Adımlarını (Steps) Kaydet
        foreach ($request->steps as $index => $stepDescription) {
            RecipeStep::create([
                'recipe_id' => $recipe->id,
                'step_number' => $index + 1,
                'description' => $stepDescription,
            ]);
        }

        // Kaydedilen verinin son halini ilişkileriyle beraber geri döndür
        $recipe->load(['ingredients', 'steps']);

        return response()->json([
            'message' => 'Tarif başarıyla eklendi ve onaya gönderildi.',
            'recipe' => $recipe
        ], 201);
    }
}