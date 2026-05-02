<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiChefController extends Controller
{
    // Arayüzü gösteren metod
    public function index()
    {
        return view('ai-chef.index');
    }

    // Form gönderildiğinde AI'a bağlanacak metod
    public function generateRecipe(Request $request)
    {
        $request->validate(['ingredients' => 'required|string|min:3']);
        $ingredients = $request->input('ingredients');

        $apiKey = trim(env('GEMINI_API_KEY'));
        $unsplashKey = trim(env('UNSPLASH_API_KEY'));

        if (empty($apiKey)) {
            return back()->with('error', 'Hata: API Key okunamadı. .env dosyasını kontrol edin.');
        }

        try {
            // 1. DİNAMİK MODEL BULUCU (Senin sorunsuz çalışan sistemin)
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
                    return back()->with('error', 'Uygun model bulunamadı.');
                }

                // 2. İNGİLİZCE İSİM VE TÜRKÇE TARİF İSTEYEN YENİ PROMPT
                $prompt = "Sen yaratıcı bir şefsin. Elindeki malzemeler: " . $ingredients . ".
                Lütfen cevabını KESİNLİKLE şu formatta ver:
                KEYWORD: [Yemeğin İngilizce adı, sadece kelimeler. Örn: creamy mushroom pasta]
                RECIPE: [Yemeğin adı, malzemeler ve yapılışını içeren Türkçe tarif]";

                $url = "https://generativelanguage.googleapis.com/v1beta/{$targetModel}:generateContent?key=" . $apiKey;

                // DİKKAT: Kotayı sömürmemek için "retry" kaldırıldı! Sadece 1 kez istek atacak.
                $response = Http::withoutVerifying()
                    ->timeout(60)
                    ->withHeaders(['Content-Type' => 'application/json'])
                    ->post($url, [
                        'contents' => [['parts' => [['text' => $prompt]]]]
                    ]);

                if ($response->successful()) {
                    $fullText = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? '';

                    // 3. GELEN CEVABI PARÇALAMA
                    $imageKeyword = "delicious food";
                    $recipeContent = $fullText;

                    if (str_contains($fullText, 'RECIPE:')) {
                        $parts = explode('RECIPE:', $fullText);
                        $imageKeyword = trim(str_replace(['KEYWORD:', '**KEYWORD:**', '*'], '', $parts[0]));
                        $recipeContent = trim($parts[1]);
                    }

                    // 4. UNSPLASH FOTOĞRAF ÇEKİMİ
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

                    return view('ai-chef.index', compact('recipeContent', 'imageUrl'));

                } else {
                    $msg = $response->json()['error']['message'] ?? 'Bilinmeyen hata';
                    return back()->with('error', "Google Hatası: {$msg}");
                }
            } else {
                return back()->with('error', 'Google Modelleri listelenemedi.');
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Bağlantı koptu: ' . $e->getMessage());
        }
    }
}
