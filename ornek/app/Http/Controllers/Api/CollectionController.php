<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecipeList;
use App\Models\Recipe;

class CollectionController extends Controller
{
    // 1. Kullanıcının tüm listelerini getir
    public function index(Request $request)
    {
        $lists = RecipeList::where('user_id', $request->user()->id)->get();

        return response()->json([
            'data' => $lists
        ], 200);
    }

    // 2. Mobilden yeni bir liste oluşturma
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $list = RecipeList::create([
            'user_id' => $request->user()->id,
            'name' => $request->input('name')
        ]);

        return response()->json([
            'message' => 'Liste başarıyla oluşturuldu.',
            'data' => $list
        ], 201);
    }

    // 3. İlgili listeye tarif ekle veya çıkar (Toggle)
    public function toggleRecipe(Request $request, $listId, $recipeId)
    {
        $user = $request->user();

        // Listeyi bul ve gerçekten bu kullanıcıya mı ait kontrol et (Güvenlik)
        $list = RecipeList::where('id', $listId)->where('user_id', $user->id)->first();
        if (!$list) {
            return response()->json(['message' => 'Liste bulunamadı veya yetkiniz yok.'], 404);
        }

        // Tarif veritabanında var mı kontrol et
        $recipe = Recipe::find($recipeId);
        if (!$recipe) {
            return response()->json(['message' => 'Tarif bulunamadı.'], 404);
        }

        // Çoka-çok ilişkiyi kullanarak ekle/çıkar
        $list->recipes()->toggle($recipeId);

        // Tarif şu an listede var mı?
        $isAdded = $list->recipes()->where('recipe_id', $recipeId)->exists();

        return response()->json([
            'message' => $isAdded ? "Tarif '{$list->name}' listesine eklendi." : "Tarif '{$list->name}' listesinden çıkarıldı.",
            'is_added' => $isAdded
        ], 200);
    }
    // Belirli bir listenin içindeki tarifleri getir
    public function show(Request $request, $id)
    {
        // Listeyi bul ve içindeki tarifleri (yazar ve kategori bilgileriyle) getir
        $list = RecipeList::with(['recipes.user', 'recipes.category'])
            ->where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$list) {
            return response()->json(['message' => 'Liste bulunamadı.'], 404);
        }

        return response()->json([
            'data' => $list->recipes
        ], 200);
    }
}
