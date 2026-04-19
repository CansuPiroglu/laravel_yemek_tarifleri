<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // Tarif silinirse yorumlar da silinsin (cascade)
            $table->foreignId('recipe_id')->constrained()->onDelete('cascade');
            // Kullanıcı ID'si (Şimdilik auth sistemi tam olmadığı için nullable yapıyoruz)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->tinyInteger('rating'); // 1 ile 5 arası yıldız puanı
            $table->text('comment'); // Yorum metni
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
