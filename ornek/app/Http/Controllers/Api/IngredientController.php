<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ingredient;

class IngredientController extends Controller
{
    /**
     * MALZEME LİSTESİ (arama ile)
     *
     * GET /api/ingredients?search=domates
     *
     * Flutter'daki AI asistanı ekranında autocomplete için kullanılır.
     */
    public function index(Request $request)
    {
        // 1. URL'den 'search' parametresini al (Örn: ?search=domates)
        $search = $request->query('search');

        // 2. Eğer arama kelimesi gönderilmişse filtrele, gönderilmemişse hepsini getir
        if ($search) {
            $ingredients = Ingredient::where('name', 'like', "%{$search}%")
                                     ->limit(10)
                                     ->get();
        } else {
            $ingredients = Ingredient::all();
        }

        // 3. Sonuçları JSON formatında mobil uygulamaya döndür
        return response()->json($ingredients, 200);
    }
}