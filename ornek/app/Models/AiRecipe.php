<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AiRecipe extends Model
{
    use HasFactory;

    // Laravel'e dışarıdan toplu olarak hangi verilerin kaydedilebileceğini söylüyoruz
    protected $fillable = [
        'title',
        'content',
        'image_url',
    ];
}
