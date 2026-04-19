<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Sistemde olmasını istediğimiz sabit kategoriler
        $categories = [
            'Kahvaltılıklar',
            'Çorbalar',
            'Ana Yemekler',
            'Zeytinyağlılar',
            'Tatlılar',
            'İçecekler',
            'Atıştırmalıklar'
        ];

        // Döngü ile hepsini veritabanına kaydediyoruz
        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category)
            ]);
        }
    }
}
