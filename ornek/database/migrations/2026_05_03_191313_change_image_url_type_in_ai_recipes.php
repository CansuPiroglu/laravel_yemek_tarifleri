<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // image_url sütununu limitsiz TEXT türüne çeviriyoruz
        DB::statement('ALTER TABLE ai_recipes MODIFY image_url TEXT');
    }

    public function down()
    {
        // Geri alınmak istenirse tekrar 255 karaktere düşürür
        DB::statement('ALTER TABLE ai_recipes MODIFY image_url VARCHAR(255)');
    }
};