<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecipeList;
use App\Models\AiRecipe;

class CollectionController extends Controller
{
    // 1. Kullanıcının tüm klasörlerini gösterecek sayfa
    public function index()
    {
        // Şimdilik 1 numaralı kullanıcının listelerini ve içindeki tarif sayısını çekiyoruz
        $collections = RecipeList::withCount('recipes')->where('user_id', 1)->latest()->get();

        $aiRecipeCount = AiRecipe::count(); // AI tariflerinin sayısını say

        // compact içine 'aiRecipeCount' değişkenini de eklemeyi unutma!
        return view('collections.index', compact('collections', 'aiRecipeCount'));
    }

    // 2. Bir klasörün içine tıklandığında içindeki tarifleri gösterecek sayfa
    public function show(RecipeList $collection)
    {
        // Koleksiyonun içindeki tarifleri hızlıca yüklüyoruz
        $collection->load('recipes');
        return view('collections.show', compact('collection'));
    }
}
