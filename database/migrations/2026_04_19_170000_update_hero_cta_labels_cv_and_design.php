<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('website_settings')) {
            return;
        }

        DB::table('website_settings')->where('id', 1)->update([
            'hero_cta_primary_label_en' => 'Download CV',
            'hero_cta_primary_label_my' => 'CV ရယူရန်',
            'hero_cta_primary_url' => null,
            'hero_cta_secondary_label_en' => 'Start a Design',
            'hero_cta_secondary_label_my' => 'ဒီဇိုင်း စတင်ရန်',
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('website_settings')) {
            return;
        }

        DB::table('website_settings')->where('id', 1)->update([
            'hero_cta_primary_label_en' => 'Explore designs',
            'hero_cta_primary_label_my' => 'ဒီဇိုင်းများ ကြည့်ရန်',
            'hero_cta_secondary_label_en' => 'Download media kit',
            'hero_cta_secondary_label_my' => 'မီဒီယာ ကိတ်ရယူရန်',
            'updated_at' => now(),
        ]);
    }
};
