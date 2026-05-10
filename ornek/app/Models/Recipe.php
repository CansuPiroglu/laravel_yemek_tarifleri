<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipe extends Model
{
    use HasFactory, SoftDeletes;

    // 1. Tarifin bağlı olduğu Kategori ilişkisi
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 2. Tarifi ekleyen Kullanıcı (Yazar) ilişkisi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Bir tarifin birden fazla hazırlama adımı vardır
    public function steps()
    {
        return $this->hasMany(RecipeStep::class)->orderBy('step_number');
    }

    // Bir tarifin birçok malzemesi olabilir (Pivot tablo üzerinden)
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)
            ->withPivot('quantity', 'unit'); // Pivot sütunlarını da getir
    }

    // Bir tarifin birden fazla yorumu olabilir (En yeniler en üstte gelsin)
    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }

    protected $fillable = [
        'user_id','category_id','title','slug',
        'description','prep_time','cook_time','servings','image_path',
    ];

    public function lists()
    {
        return $this->belongsToMany(RecipeList::class, 'list_recipe', 'recipe_id', 'recipe_list_id');
    }

    // Accessor'lar

    // Ortlama puanı hesaplar (API cevabına otomatik eklenir)
    public function getAverageRatingAttribute(): ?float
    {
        return $this->reviews()->avg('rating');
    }
}
