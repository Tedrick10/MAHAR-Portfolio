<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->renameColumn('social_instagram', 'social_facebook');
            $table->renameColumn('social_behance', 'social_telegram');
            $table->renameColumn('social_dribbble', 'social_viber');
            $table->renameColumn('social_linkedin', 'social_tiktok');
        });
    }

    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->renameColumn('social_facebook', 'social_instagram');
            $table->renameColumn('social_telegram', 'social_behance');
            $table->renameColumn('social_viber', 'social_dribbble');
            $table->renameColumn('social_tiktok', 'social_linkedin');
        });
    }
};
