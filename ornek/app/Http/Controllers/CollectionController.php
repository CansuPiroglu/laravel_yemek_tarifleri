<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecipeList;

class CollectionController extends Controller
{
    // 1. Kullanıcının tüm klasörlerini gösterecek sayfa
    public function index()
    {
        // Şimdilik 1 numaralı kullanıcının listelerini ve içindeki tarif sayısını çekiyoruz
        $collections = RecipeList::withCount('recipes')->where('user_id', 1)->latest()->get();
        return view('collections.index', compact('collections'));
    }

    // 2. Bir klasörün içine tıklandığında içindeki tarifleri gösterecek sayfa
    public function show(RecipeList $collection)
    {
        // Koleksiyonun içindeki tarifleri hızlıca yüklüyoruz
        $collection->load('recipes');
        return view('collections.show', compact('collection'));
    }
}
