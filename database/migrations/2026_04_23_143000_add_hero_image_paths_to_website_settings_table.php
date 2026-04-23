<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('website_settings', function (Blueprint $table): void {
            $table->json('hero_image_paths')->nullable()->after('hero_image_path');
        });

        DB::table('website_settings')
            ->whereNotNull('hero_image_path')
            ->whereNull('hero_image_paths')
            ->update([
                'hero_image_paths' => DB::raw("JSON_ARRAY(hero_image_path)"),
            ]);
    }

    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table): void {
            $table->dropColumn('hero_image_paths');
        });
    }
};
