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
            $table->text('contact_google_maps_share_url')->nullable()->after('contact_hours_my');
        });

        if (Schema::hasColumn('website_settings', 'contact_google_maps_embed_url')) {
            DB::table('website_settings')
                ->whereNotNull('contact_google_maps_embed_url')
                ->where('contact_google_maps_embed_url', '!=', '')
                ->update([
                    'contact_google_maps_share_url' => DB::raw('contact_google_maps_embed_url'),
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn('contact_google_maps_share_url');
        });
    }
};
