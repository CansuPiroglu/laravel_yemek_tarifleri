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
        Schema::create('files', function (Blueprint $table) {
            $table->id();

            // Hangi tarife ait olduğunu belirten bağlantı (Tarif silinirse dosyaları da silinsin)
            $table->foreignId('recipe_id')->constrained()->cascadeOnDelete();

            // Dosyanın sunucudaki kayıtlı yolu/adı
            $table->string('file_path');

            // Dosya türünü belirtmek için (örneğin: resim, pdf, video)
            $table->string('file_type')->default('image');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
