<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolio_items', function (Blueprint $table) {
            $table->json('detail_media')->nullable()->after('gallery_paths');
        });

        $rows = DB::table('portfolio_items')->select(['id', 'gallery_paths'])->get();
        foreach ($rows as $row) {
            $raw = $row->gallery_paths;
            $paths = is_string($raw) ? json_decode($raw, true) : $raw;
            if (! is_array($paths) || $paths === []) {
                continue;
            }
            $detailMedia = [];
            foreach ($paths as $path) {
                if (! is_string($path) || trim($path) === '') {
                    continue;
                }
                $detailMedia[] = ['type' => 'image', 'path' => $path];
            }
            if ($detailMedia !== []) {
                DB::table('portfolio_items')->where('id', $row->id)->update([
                    'detail_media' => json_encode($detailMedia),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('portfolio_items', function (Blueprint $table) {
            $table->dropColumn('detail_media');
        });
    }
};
