<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->string('cv_pdf_en_path')->nullable()->after('favicon_path');
            $table->string('cv_pdf_my_path')->nullable()->after('cv_pdf_en_path');
        });
    }

    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn(['cv_pdf_en_path', 'cv_pdf_my_path']);
        });
    }
};
