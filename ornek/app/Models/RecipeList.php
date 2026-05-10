<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecipeList extends Model
{
    use HasFactory;

    // PHP'deki 'List' kelimesiyle karışmasın diye tabloyu manuel belirtiyoruz
    protected $table = 'lists';
    protected $fillable = ['user_id', 'name'];

    // Bu listedeki tarifleri çekmek için
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'list_recipe', 'recipe_list_id', 'recipe_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
