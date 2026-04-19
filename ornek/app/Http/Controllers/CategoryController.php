<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Sadece mevcut sabit kategorileri admin panelinde liste halinde görmek istersek:
    public function index()
    {
        $categories = Category::latest()->get();
        return view('categories.index', compact('categories'));
    }

    // DİKKAT: create, store, edit, update ve destroy fonksiyonlarını tamamen sildik!
    // Çünkü artık dışarıdan manuel olarak kategori eklenmesini, silinmesini
    // veya adının değiştirilmesini istemiyoruz.
}
