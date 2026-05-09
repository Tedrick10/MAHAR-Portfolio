<?php

use App\Models\PortfolioItem;
use Illuminate\Database\Migrations\Migration;

/**
 * Some popular music videos block third-party iframe playback everywhere (YouTube-level).
 * Replace the common demo URL with a Blender-hosted sample that reliably allows embedding.
 */
return new class extends Migration
{
    private const BLOCKED_IDS = ['725WlG1idPc'];

    private const REPLACEMENT_WATCH_URL = 'https://www.youtube.com/watch?v=aqz-KE-bpKQ';

    public function up(): void
    {
        $blocked = implode('|', array_map(static fn (string $id) => preg_quote($id, '/'), self::BLOCKED_IDS));
        $pattern = '/'.$blocked.'/';

        PortfolioItem::query()->whereNotNull('detail_media')->each(function (PortfolioItem $item) use ($pattern): void {
            $dm = $item->detail_media;
            if (! is_array($dm)) {
                return;
            }

            $changed = false;
            foreach ($dm as &$row) {
                if (! is_array($row) || ($row['type'] ?? '') !== 'youtube') {
                    continue;
                }
                $url = (string) ($row['url'] ?? '');
                if ($url !== '' && preg_match($pattern, $url)) {
                    $row['url'] = self::REPLACEMENT_WATCH_URL;
                    $changed = true;
                }
            }
            unset($row);

            if ($changed) {
                $item->forceFill(['detail_media' => $dm])->save();
            }
        });
    }

    public function down(): void
    {
        // Cannot restore removed links safely; no-op.
    }
};
