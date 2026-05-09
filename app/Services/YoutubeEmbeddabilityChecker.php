<?php

namespace App\Services;

use App\Support\YoutubeEmbed;
use Illuminate\Support\Facades\Http;

final class YoutubeEmbeddabilityChecker
{
    /**
     * @return null could not verify (no API key or API error)
     * @return bool true if allowed to embed on third-party sites
     */
    public static function embeddable(string $watchOrShareUrl): ?bool
    {
        $id = YoutubeEmbed::videoIdFromUrl($watchOrShareUrl);
        if ($id === null || ! filled(config('services.youtube.api_key'))) {
            return null;
        }

        $response = Http::timeout(12)
            ->acceptJson()
            ->get('https://www.googleapis.com/youtube/v3/videos', [
                'part' => 'status',
                'id' => $id,
                'key' => config('services.youtube.api_key'),
            ]);

        if (! $response->successful()) {
            return null;
        }

        $items = $response->json('items');
        if (! is_array($items) || $items === []) {
            return false;
        }

        return (bool) data_get($items, '0.status.embeddable');
    }
}
