<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = ['name'];

    // Pivot tablosundaki quantity ve unit alanlarına erişmek için withPivot kullanılır
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class)->withPivot('quantity', 'unit');
    }
}