<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('website_settings')->where('id', 1)->update([
            'portfolio_heading_en' => 'Designs',
            'portfolio_heading_my' => 'ဒီဇိုင်းများ',
        ]);

        $portfolio = [
            'aurora-coffee-brand' => 'demo-portfolio/aurora-coffee-brand.jpg',
            'pulse-festival' => 'demo-portfolio/pulse-festival.jpg',
            'northline-editorial' => 'demo-portfolio/northline-editorial.jpg',
            'kite-mobile-app' => 'demo-portfolio/kite-mobile-app.jpg',
            'loom-packaging' => 'demo-portfolio/loom-packaging.jpg',
            'signal-poster' => 'demo-portfolio/signal-poster.jpg',
        ];

        foreach ($portfolio as $slug => $imagePath) {
            DB::table('portfolio_items')->where('slug', $slug)->update(['image_path' => $imagePath]);
        }

        $partners = DB::table('partners')->orderBy('sort_order')->orderBy('id')->pluck('id');
        $i = 0;
        foreach ($partners as $id) {
            DB::table('partners')->where('id', $id)->update(['logo_path' => 'demo-partners/'.$i.'.jpg']);
            $i++;
            if ($i > 2) {
                $i = 0;
            }
        }
    }

    public function down(): void
    {
        //
    }
};
