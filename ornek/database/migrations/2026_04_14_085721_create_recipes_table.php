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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id()->autoIncrement();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

            $table->string('title',100);
            $table->string('slug',100)->unique();
            $table->text('description');

            $table->integer('prep_time')->comment('Hazırlama süresi (dk)');
            $table->integer('cook_time')->comment('Pişirme süresi (dk)');
            $table->integer('servings')->comment('Kaç kişilik');

            $table->string('image_path')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
