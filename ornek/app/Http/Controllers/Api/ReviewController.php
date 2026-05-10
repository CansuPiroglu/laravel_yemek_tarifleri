<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * YORUM EKLE (auth gerekli) — FAZ 2
     *
     * POST /api/recipes/{recipeId}/reviews
     * Body: { rating: 4, comment: "Harika bir tarif!" }
     */
    public function store(Request $request, int $recipeId)
    {
        // 1. Gelen veriyi doğrula (Puan 1-5 arası tam sayı olmalı, yorum ise isteğe bağlı)
        $validatedData = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        // Opsiyonel ama hayat kurtaran bir güvenlik kontrolü: 
        // Kullanıcı var olmayan bir ID'ye yorum yapmaya çalışırsa sistem çökmek yerine 404 döndürsün.
        $recipe = Recipe::findOrFail($recipeId);

        // 2. updateOrCreate
        // İlk dizi: Aranacak koşul (Bu kullanıcı, bu tarife daha önce yorum yapmış mı?)
        // İkinci dizi: Eklenecek veya güncellenecek veri
        $review = Review::updateOrCreate(
            [
                'recipe_id' => $recipe->id,
                'user_id' => $request->user()->id,
            ],
            [
                'rating' => $validatedData['rating'],
                'comment' => $validatedData['comment'],
            ]
        );

        // 3. JSON formatında başarılı (201) yanıtını döndür
        return response()->json([
            'message' => 'Yorumunuz başarıyla kaydedildi.',
            'review' => $review
        ], 201);
    }
}