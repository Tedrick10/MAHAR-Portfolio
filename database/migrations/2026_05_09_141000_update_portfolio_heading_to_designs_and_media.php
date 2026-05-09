<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('website_settings')->update([
            'portfolio_heading_en' => 'Designs and Media',
            'portfolio_heading_my' => 'ဒီဇိုင်းနှင့် မီဒီယာ',
        ]);
    }

    public function down(): void
    {
        DB::table('website_settings')->update([
            'portfolio_heading_en' => 'Designs',
            'portfolio_heading_my' => 'ဒီဇိုင်းများ',
        ]);
    }
};
