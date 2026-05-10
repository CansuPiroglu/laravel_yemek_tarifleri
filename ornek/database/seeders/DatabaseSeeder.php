<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\RecipeStep;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    public function run(): void
    {
        // User::factory(10)->create();
        // ── Kullanıcılar ──────────────────────────────────────────────────

        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@yazye.com',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        $user = User::create([
            'name'     => 'Test Kullanıcı',
            'email'    => 'test@yazye.com',
            'password' => bcrypt('password'),
            'role'     => 'user',
        ]);

        // ── Kategoriler ───────────────────────────────────────────────────
        $categories = ['Çorbalar', 'Ana Yemekler', 'Tatlılar', 'Salatalar', 'Pratik Tarifler', 'Yöresel'];
        $createdCategories = [];
        foreach ($categories as $name) {
            $createdCategories[] = Category::create(['name' => $name, 'slug' => Str::slug($name)]);
        }

        // ── Malzemeler ────────────────────────────────────────────────────
        $ingredientNames = ['Tavuk Göğsü', 'Domates', 'Soğan', 'Sarımsak', 'Zeytinyağı',
            'Tuz', 'Karabiber', 'Un', 'Yumurta', 'Süt','Kırmızı Mercimek','Nişasta','Vanilya',
            'Tereyağı', 'Krema', 'Mantar', 'Pirinç', 'Makarna','Havuç'];
        $createdIngredients = [];
        foreach ($ingredientNames as $name) {
            $createdIngredients[$name] = Ingredient::create(['name' => $name]);
        }

        // ── Örnek Tarif ───────────────────────────────────────────────────

        $recipe = Recipe::create([
            'user_id'     => $user->id,
            'category_id' => $createdCategories[1]->id, // Ana Yemekler
            'title'       => 'Kremalı Tavuk',
            'slug'        => 'kremali-tavuk',
            'description' => 'Evde kolayca yapabileceğiniz, krema soslu nefis bir tavuk tarifi.',
            'prep_time'   => 15,
            'cook_time'   => 30,
            'servings'    => 4,
        ]);

        // Malzeme bağlama (pivot)
        $recipe->ingredients()->attach([
            $createdIngredients['Tavuk Göğsü']->id => ['quantity' => '600', 'unit' => 'gram'],
            $createdIngredients['Krema']->id        => ['quantity' => '200', 'unit' => 'ml'],
            $createdIngredients['Mantar']->id       => ['quantity' => '200', 'unit' => 'gram'],
            $createdIngredients['Soğan']->id        => ['quantity' => '1',   'unit' => 'adet'],
            $createdIngredients['Sarımsak']->id     => ['quantity' => '3',   'unit' => 'diş'],
            $createdIngredients['Tereyağı']->id     => ['quantity' => '2',   'unit' => 'yemek kaşığı'],
            $createdIngredients['Tuz']->id          => ['quantity' => null,  'unit' => 'tatmak için'],
            $createdIngredients['Karabiber']->id    => ['quantity' => null,  'unit' => 'tatmak için'],
        ]);

        // Adımlar
        $steps = [
            'Tavuk göğüslerini küp küp doğrayın ve tuzlayın.',
            'Tavada tereyağını eritin, soğan ve sarımsağı kavurun.',
            'Tavukları ekleyin ve her tarafı mühürleyin (5-6 dakika).',
            'Mantarları ekleyin ve 3 dakika daha kavurun.',
            'Kremayı dökün, tuz ve karabiber ekleyin.',
            'Kısık ateşte 10-15 dakika pişirin, sos koyulaşsın.',
            'Sıcak servis edin. Afiyet olsun!',
        ];

        foreach ($steps as $i => $instruction) {
            RecipeStep::create([
                'recipe_id'   => $recipe->id,
                'step_number' => $i + 1,
                'instruction' => $instruction,
            ]);
        }

        // ── Örnek Tarif 2: Süzme Mercimek Çorbası ─────────────────────────────
        $recipe2 = Recipe::create([
            'user_id'     => $user->id,
            'category_id' => $createdCategories[0]->id, // Çorbalar (Varsayılan olarak 0. index farz ettik)
            'title'       => 'Süzme Mercimek Çorbası',
            'slug'        => 'suzme-mercimek-corbasi',
            'description' => 'İç ısıtan, lokanta usulü pürüzsüz ve tam kıvamında süzme mercimek çorbası.',
            'prep_time'   => 10,
            'cook_time'   => 25,
            'servings'    => 6,
        ]);

        // Malzeme bağlama (pivot)
        $recipe2->ingredients()->attach([
            $createdIngredients['Kırmızı Mercimek']->id => ['quantity' => '1', 'unit' => 'su bardağı'],
            $createdIngredients['Soğan']->id            => ['quantity' => '1', 'unit' => 'adet'],
            $createdIngredients['Havuç']->id            => ['quantity' => '1', 'unit' => 'adet'],
            $createdIngredients['Patates']->id          => ['quantity' => '1', 'unit' => 'adet'],
            $createdIngredients['Tereyağı']->id         => ['quantity' => '2', 'unit' => 'yemek kaşığı'],
            $createdIngredients['Tuz']->id              => ['quantity' => null, 'unit' => 'tatmak için'],
        ]);

        // Adımlar
        $steps2 = [
            'Soğanı, havucu ve patatesi iri parçalar halinde doğrayın.',
            'Tencerede tereyağını eritip doğradığınız sebzeleri 2-3 dakika kadar kavurun.',
            'Yıkanmış mercimekleri ekleyip üzerini 3-4 parmak geçecek kadar sıcak su ilave edin.',
            'Sebzeler ve mercimekler tamamen yumuşayana kadar yaklaşık 20-25 dakika kaynatın.',
            'Pişen çorbayı tamamen pürüzsüz olana kadar blenderdan geçirin.',
            'Tuzunu ayarlayıp sıcak servis yapın. İsterseniz üzerine pul biberli yağ gezdirebilirsiniz.',
        ];

        foreach ($steps2 as $i => $instruction) {
            RecipeStep::create([
                'recipe_id'   => $recipe2->id,
                'step_number' => $i + 1,
                'instruction' => $instruction,
            ]);
        }

        // ── Örnek Tarif 3: Fırın Sütlaç ───────────────────────────────────────
        $recipe3 = Recipe::create([
            'user_id'     => $user->id,
            'category_id' => $createdCategories[2]->id, // Tatlılar (Varsayılan olarak 2. index farz ettik)
            'title'       => 'Fırın Sütlaç',
            'slug'        => 'firin-sutlac',
            'description' => 'Üzeri nar gibi kızarmış, kıvamı tam yerinde geleneksel fırın sütlaç.',
            'prep_time'   => 15,
            'cook_time'   => 40,
            'servings'    => 4,
        ]);

        // Malzeme bağlama (pivot)
        $recipe3->ingredients()->attach([
            $createdIngredients['Süt']->id           => ['quantity' => '1', 'unit' => 'litre'],
            $createdIngredients['Pirinç']->id        => ['quantity' => '1/2', 'unit' => 'su bardağı'],
            $createdIngredients['Toz Şeker']->id     => ['quantity' => '1', 'unit' => 'su bardağı'],
            $createdIngredients['Nişasta']->id       => ['quantity' => '3', 'unit' => 'yemek kaşığı'],
            $createdIngredients['Vanilya']->id       => ['quantity' => '1', 'unit' => 'paket'],
        ]);

        // Adımlar
        $steps3 = [
            'Pirinçleri yıkayıp 2 su bardağı su ile yumuşayana kadar haşlayın.',
            'Haşlanan pirinçlerin üzerine sütü ve şekeri ilave edip kaynamaya bırakın.',
            'Nişastayı yarım çay bardağı su ile ezip açın ve kaynayan süte yavaşça ekleyerek karıştırın.',
            'Kıvam alana kadar yaklaşık 10 dakika daha kaynatın, ardından vanilyayı ekleyip altını kapatın.',
            'Sütlacı ısıya dayanıklı fırın kaplarına paylaştırın.',
            'Kapları fırın tepsisine dizin ve tepsinin yarısına kadar soğuk su doldurun.',
            'Önceden ısıtılmış 200 derece fırının en üst rafında üzerleri kızarana kadar pişirin.',
        ];

        foreach ($steps3 as $i => $instruction) {
            RecipeStep::create([
                'recipe_id'   => $recipe3->id,
                'step_number' => $i + 1,
                'instruction' => $instruction,
            ]);
        }
    }
}
