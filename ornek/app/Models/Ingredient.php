<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    // Malzeme adının dışarıdan doldurulmasına izin veriyoruz
    protected $fillable = [
        'name'
    ];
}
