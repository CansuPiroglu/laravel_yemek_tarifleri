<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CategoryController; // Kategori Controller'ını içeri aktardık
use App\Http\Controllers\CollectionController; // Bunu en üste use kısmına ekle
use App\Http\Controllers\DashboardController;


// Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/', function() {
    return view('welcome');
}) ->name('home');

Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard');

//Route::get('/admin', function () {
//    return view('admin.index');
//})->name('admin_home');

//Route::view('dashboard', 'dashboard')
//    ->middleware(['auth', 'verified'])
//    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::resource('recipes', RecipeController::class);

// Tarif detay sayfasından Malzeme ve Adım eklemek için özel rotalar
Route::post('recipes/{recipe}/ingredients', [RecipeController::class, 'addIngredient'])->name('recipes.ingredients.store');
Route::post('recipes/{recipe}/steps', [RecipeController::class, 'addStep'])->name('recipes.steps.store');

// Kategoriler için olan yeni rotamız
Route::resource('categories', CategoryController::class);

Route::post('recipes/{recipe}/reviews', [RecipeController::class, 'addReview'])->name('recipes.reviews.store');

Route::post('recipes/{recipe}/toggle-list', [RecipeController::class, 'toggleList'])->name('recipes.toggle-list');

// Bunu da alt kısımdaki rotaların yanına ekle
Route::get('collections', [CollectionController::class, 'index'])->name('collections.index');
Route::get('collections/{collection}', [CollectionController::class, 'show'])->name('collections.show');

require __DIR__.'/auth.php';
