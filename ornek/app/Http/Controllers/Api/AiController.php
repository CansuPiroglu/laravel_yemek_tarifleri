<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{
    public function suggest(Request $request)
    {
        // Flutter'dan malzemeler dizi (array) olarak geliyor
        $request->validate(['ingredients' => 'required|array']);

        // Diziyi alıp aralarına virgül koyarak metne çeviriyoruz (örn: "tavuk, krema, mantar")
        $ingredientsList = implode(', ', $request->input('ingredients'));

        $apiKey = trim(env('GEMINI_API_KEY'));
        $unsplashKey = trim(env('UNSPLASH_API_KEY'));

        if (empty($apiKey)) {
            return response()->json(['message' => 'Hata: API Key okunamadı. .env dosyasını kontrol edin.'], 500);
        }

        try {
            // 1. DİNAMİK MODEL BULUCU (Senin kodun)
            $listResponse = Http::withoutVerifying()
                ->get("https://generativelanguage.googleapis.com/v1beta/models?key=" . $apiKey);

            if ($listResponse->successful()) {
                $modelsData = $listResponse->json();
                $targetModel = "";

                if (isset($modelsData['models'])) {
                    foreach ($modelsData['models'] as $model) {
                        $methods = $model['supportedGenerationMethods'] ?? [];
                        if (str_contains(strtolower($model['name']), 'gemini') && in_array('generateContent', $methods)) {
                            $targetModel = $model['name'];
                            break;
                        }
                    }
                }

                if (empty($targetModel)) {
                    return response()->json(['message' => 'Uygun model bulunamadı.'], 500);
                }

                // 2. İNGİLİZCE İSİM VE TÜRKÇE TARİF İSTEYEN YENİ PROMPT (Senin kodun)
                $prompt = "Sen yaratıcı bir şefsin. Elindeki malzemeler: " . $ingredientsList . ".
                Lütfen cevabını KESİNLİKLE şu formatta ver:
                KEYWORD: [Yemeğin İngilizce adı, sadece kelimeler. Örn: creamy mushroom pasta]
                RECIPE: [Yemeğin adı, malzemeler ve yapılışını içeren Türkçe tarif]";

                $url = "https://generativelanguage.googleapis.com/v1beta/{$targetModel}:generateContent?key=" . $apiKey;

                $response = Http::withoutVerifying()
                    ->timeout(60)
                    ->withHeaders(['Content-Type' => 'application/json'])
                    ->post($url, [
                        'contents' => [['parts' => [['text' => $prompt]]]]
                    ]);

                if ($response->successful()) {
                    $fullText = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? '';

                    // 3. GELEN CEVABI PARÇALAMA (Senin kodun)
                    $imageKeyword = "delicious food";
                    $recipeContent = $fullText;

                    if (str_contains($fullText, 'RECIPE:')) {
                        $parts = explode('RECIPE:', $fullText);
                        $imageKeyword = trim(str_replace(['KEYWORD:', '**KEYWORD:**', '*'], '', $parts[0]));
                        $recipeContent = trim($parts[1]);
                    }

                    // 4. UNSPLASH FOTOĞRAF ÇEKİMİ (Senin kodun)
                    $imageUrl = "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=800&auto=format&fit=crop";

                    if (!empty($unsplashKey)) {
                        $unsplashResponse = Http::withoutVerifying()->get("https://api.unsplash.com/search/photos", [
                            'query' => $imageKeyword . ' food plate',
                            'client_id' => $unsplashKey,
                            'per_page' => 1,
                            'orientation' => 'squarish'
                        ]);

                        if ($unsplashResponse->successful() && count($unsplashResponse->json()['results']) > 0) {
                            $imageUrl = $unsplashResponse->json()['results'][0]['urls']['regular'];
                        }
                    }

                    // MOBİL İÇİN JSON DÖNDÜRÜYORUZ
                    return response()->json([
                        'recipe' => $recipeContent,
                        'image_url' => $imageUrl
                    ], 200);

                } else {
                    $msg = $response->json()['error']['message'] ?? 'Bilinmeyen hata';
                    return response()->json(['message' => "Google Hatası: {$msg}"], 500);
                }
            } else {
                return response()->json(['message' => 'Google Modelleri listelenemedi.'], 500);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => 'Bağlantı koptu: ' . $e->getMessage()], 500);
        }
    }
}
