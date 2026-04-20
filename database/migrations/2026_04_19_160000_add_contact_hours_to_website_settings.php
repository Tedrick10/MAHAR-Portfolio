<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->string('contact_hours_en')->nullable()->after('contact_address_my');
            $table->string('contact_hours_my')->nullable()->after('contact_hours_en');
        });

        if (Schema::hasTable('website_settings')) {
            DB::table('website_settings')->whereNull('contact_hours_en')->update([
                'contact_hours_en' => 'Mon – Fri: 09:00 – 18:00',
                'contact_hours_my' => 'တနင်္လာ – သောကြာ: ၀၉၀၀ – ၁၈၀၀',
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn(['contact_hours_en', 'contact_hours_my']);
        });
    }
};
