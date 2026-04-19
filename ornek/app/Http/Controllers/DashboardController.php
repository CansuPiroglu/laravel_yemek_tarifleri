<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Review;
use App\Models\RecipeList;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        // Veritabanındaki toplam sayıları say (count)
        $recipeCount = Recipe::count();
        $reviewCount = Review::count();
        $collectionCount = RecipeList::count();
        $categoryCount = Category::count(); // Eğer kategoriler tablon varsa, yoksa bunu 0 yapabilirsin

        // Alt kısımda göstermek için son eklenen 5 tarifi çek
        $latestRecipes = Recipe::latest()->take(5)->get();

        return view('dashboard', compact('recipeCount', 'reviewCount', 'collectionCount', 'categoryCount', 'latestRecipes'));
    }
}
