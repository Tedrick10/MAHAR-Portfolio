<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private function urls(): array
    {
        $dev = 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons';

        return [
            'Figma' => $dev.'/figma/figma-original.svg',
            'Adobe Illustrator' => $dev.'/illustrator/illustrator-original.svg',
            'Adobe Photoshop' => $dev.'/photoshop/photoshop-original.svg',
            'Adobe After Effects' => $dev.'/aftereffects/aftereffects-original.svg',
            'Blender' => $dev.'/blender/blender-original.svg',
            'Sketch' => $dev.'/sketch/sketch-original.svg',
        ];
    }

    private function legacyPlainUrls(): array
    {
        $dev = 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons';

        return [
            'Adobe Illustrator' => $dev.'/illustrator/illustrator-plain.svg',
            'Adobe Photoshop' => $dev.'/photoshop/photoshop-plain.svg',
            'Adobe After Effects' => $dev.'/aftereffects/aftereffects-plain.svg',
        ];
    }

    public function up(): void
    {
        if (! Schema::hasTable('design_tools')) {
            return;
        }

        foreach ($this->urls() as $name => $url) {
            DB::table('design_tools')->where('name_en', $name)->update([
                'logo_path' => $url,
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('design_tools')) {
            return;
        }

        foreach ($this->urls() as $name => $url) {
            $revert = $this->legacyPlainUrls()[$name] ?? null;
            if ($revert === null) {
                continue;
            }
            DB::table('design_tools')->where('name_en', $name)->where('logo_path', $url)->update([
                'logo_path' => $revert,
                'updated_at' => now(),
            ]);
        }
    }
};
