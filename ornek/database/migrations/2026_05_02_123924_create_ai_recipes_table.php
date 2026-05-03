<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('ai_recipes', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // Yemeğin adı
        $table->text('content'); // Tüm tarif içeriği
        $table->string('image_url')->nullable(); // Unsplash'ten gelen resim linki
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_recipes');
    }
};
