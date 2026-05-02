<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Ingredient;
use App\Models\RecipeStep;
use App\Models\Review;
use App\Models\RecipeList;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Veritabanından temel sorguyu başlat (N+1 sorunu olmaması için with kullandık)
        $query = Recipe::with(['category', 'user']);

        // 2. Dropdown (Açılır menü) için tüm kategorileri çek
        $categories = Category::all();

        // 3. İSME GÖRE ARAMA: Eğer arama kutusuna bir şey yazılmışsa
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // 4. KATEGORİYE GÖRE ARAMA: Eğer dropdown'dan kategori seçilmişse
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // 5. Sonuçları getir (Sayfa başı 12 tarif gösterecek şekilde sayfalama yapıyoruz)
        // withQueryString() ekliyoruz ki sayfa değiştirirken arama kelimesi kaybolmasın
        $recipes = $query->latest()->paginate(12)->withQueryString();

        // Verileri View'a gönder
        return view('recipes.index', compact('recipes', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Kullanıcı tarif eklerken kategori seçebilsin diye kategorileri de çekiyoruz
        $categories = Category::all();

        // recipes klasöründeki create.blade.php dosyasını aç
        return view('recipes.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Güvenlik ve Doğrulama
        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id', // Kategori artık zorunlu
            'description' => 'required',
            'prep_time' => 'required|integer',
            'cook_time' => 'required|integer',
            'servings' => 'required|integer',
        ]);

        // 2. Yeni tarifi oluştur ve verileri doldur
        $recipe = new Recipe();
        $recipe->title = $request->title;
        $recipe->slug = Str::slug($request->title);
        $recipe->category_id = $request->category_id;
        $recipe->description = $request->description;
        $recipe->prep_time = $request->prep_time;
        $recipe->cook_time = $request->cook_time;
        $recipe->servings = $request->servings;

        // 3. Yazar ataması (Senin oluşturduğun 1 ID'li Cansu kullanıcısı)
        $recipe->user_id = auth()->id() ?? 1;

        // GÖRSEL YÜKLEME İŞLEMİ
        if ($request->hasFile('image')) {
            // Dosyayı 'storage/app/public/recipes_images' klasörüne kaydet ve yolunu al
            $imagePath = $request->file('image')->store('recipes_images', 'public');
            // Veritabanındaki image_path sütununa bu yolu yaz
            $recipe->image_path = $imagePath;
        }

        // 4. Veritabanına Kaydet!
        $recipe->save();

        // 5. BAŞARIYLA YÖNLENDİR (Beyaz ekranı engelleyen sihirli satır)
        return redirect()->route('recipes.index')->with('success', 'Tarif başarıyla eklendi!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe)
    {
        // İlişkili tüm verileri 'Eager Loading' ile tek seferde çekiyoruz
        $recipe->load(['category', 'steps', 'ingredients', 'user', 'reviews']);

        return view('recipes.show', compact('recipe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $recipe)
    {
        // Kategorileri çekiyoruz çünkü düzenleme formundaki "Kategori" açılır menüsünde de lazım olacak
        $categories = Category::all();

        // recipes klasöründeki edit.blade.php sayfasını aç ve içine seçilen tarifi ve kategorileri gönder
        return view('recipes.edit', compact('recipe', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recipe $recipe)
    {
        // 1. Yine aynı güvenlik doğrulamasını yapıyoruz
        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            'prep_time' => 'required|integer',
            'cook_time' => 'required|integer',
            'servings' => 'required|integer',
        ]);

        // 2. Yeni obje oluşturmak yerine, parametre olarak gelen mevcut $recipe objesini güncelliyoruz
        $recipe->title = $request->title;
        $recipe->slug = Str::slug($request->title);
        $recipe->category_id = $request->category_id;
        $recipe->description = $request->description;
        $recipe->prep_time = $request->prep_time;
        $recipe->cook_time = $request->cook_time;
        $recipe->servings = $request->servings;

        // GÖRSEL YÜKLEME İŞLEMİ
        if ($request->hasFile('image')) {
            // Dosyayı 'storage/app/public/recipes_images' klasörüne kaydet ve yolunu al
            $imagePath = $request->file('image')->store('recipes_images', 'public');
            // Veritabanındaki image_path sütununa bu yolu yaz
            $recipe->image_path = $imagePath;
        }

        // 3. Veritabanında güncelle!
        $recipe->save();

        // 4. Listeleme sayfasına başarı mesajıyla geri dön
        return redirect()->route('recipes.index')->with('success', 'Tarif başarıyla güncellendi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        // 1. Tarifi sil
        $recipe->delete();

        // 2. Listeleme sayfasına başarı mesajıyla dön
        return redirect()->route('recipes.index')->with('success', 'Tarif başarıyla silindi!');
    }

    // --- YENİ EKLENEN MODÜLER FONKSİYONLAR ---

    public function addIngredient(Request $request, Recipe $recipe)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric',
            'unit' => 'required|string|max:50',
        ]);

        // MÜHENDİSLİK DETAYI: firstOrCreate komutu harikadır!
        // Kullanıcının yazdığı malzemeyi (örn: Domates) sözlükte arar.
        // Varsa onu seçer, yoksa sözlüğe yeni kayıt olarak ekler.
        $ingredient = Ingredient::firstOrCreate([
            'name' => mb_strtolower($request->name) // Büyük/küçük harf duyarlılığını kaldırmak için
        ]);

        // Pivot tabloya (ingredient_recipe) verileri bağlıyoruz
        $recipe->ingredients()->attach($ingredient->id, [
            'quantity' => $request->quantity,
            'unit' => $request->unit
        ]);

        // back() komutu kullanıcıyı geldiği sayfaya (show sayfasına) geri döndürür
        return back()->with('success', 'Malzeme başarıyla eklendi!');
    }

    public function addStep(Request $request, Recipe $recipe)
    {
        $request->validate([
            'step_number' => 'required|integer',
            'instruction' => 'required|string',
        ]);

        // Tarifin adımlarına yeni bir adım oluşturup ekliyoruz
        $recipe->steps()->create([
            'step_number' => $request->step_number,
            'instruction' => $request->instruction,
        ]);

        return back()->with('success', 'Hazırlama adımı eklendi!');
    }

    public function addReview(Request $request, Recipe $recipe)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $recipe->reviews()->create([
            'user_id' => auth()->id() ?? 1, // Sisteme giriş yapmış kullanıcı yoksa 1 ID'li kullanıcıyı ata
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Değerlendirmeniz başarıyla eklendi, teşekkürler!');
    }

    public function toggleList(Request $request, Recipe $recipe)
    {
        $request->validate([
            'list_name' => 'nullable|string|max:255',
            'list_id' => 'nullable|exists:lists,id'
        ]);

        $userId = auth()->id() ?? 1; // Şimdilik giriş yapmış kullanıcı yoksa 1

        // Eğer yeni bir liste adı yazıldıysa önce listeyi oluştur
        if ($request->list_name) {
            $list = RecipeList::create([
                'user_id' => $userId,
                'name' => $request->list_name
            ]);
            $listId = $list->id;
        } else {
            $listId = $request->list_id;
        }

        // Tarifi listeye ekle (Eğer zaten varsa çıkar - toggle mantığı)
        if ($listId) {
            $recipe->lists()->toggle($listId);
        }

        return back()->with('success', 'Koleksiyon güncellendi!');
    }
}
