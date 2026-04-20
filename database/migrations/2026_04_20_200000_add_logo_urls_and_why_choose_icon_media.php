<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('design_tools', function (Blueprint $table) {
            $table->string('logo_external_url')->nullable()->after('logo_path');
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->string('logo_external_url')->nullable()->after('logo_path');
        });

        Schema::table('why_choose_points', function (Blueprint $table) {
            $table->string('icon_external_url')->nullable()->after('icon');
            $table->string('icon_image_path')->nullable()->after('icon_external_url');
        });
    }

    public function down(): void
    {
        Schema::table('design_tools', function (Blueprint $table) {
            $table->dropColumn('logo_external_url');
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn('logo_external_url');
        });

        Schema::table('why_choose_points', function (Blueprint $table) {
            $table->dropColumn(['icon_external_url', 'icon_image_path']);
        });
    }
};
