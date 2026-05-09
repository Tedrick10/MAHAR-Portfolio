<?php

namespace App\Support;

use App\Services\YoutubeEmbeddabilityChecker;
use Illuminate\Validation\ValidationException;

final class PortfolioYoutubeEmbeddability
{
    /**
     * @param  array<string, mixed>  $data
     *
     * @throws ValidationException
     */
    public static function assertDetailMediaYoutubeEmbeddable(array $data): void
    {
        $rows = $data['detail_media'] ?? null;
        if (! is_array($rows)) {
            return;
        }

        $messages = [];

        foreach ($rows as $index => $row) {
            if (! is_array($row) || (($row['type'] ?? '') !== 'youtube')) {
                continue;
            }

            $url = trim((string) ($row['youtube_url'] ?? $row['url'] ?? ''));
            if ($url === '') {
                continue;
            }

            $canEmbed = YoutubeEmbeddabilityChecker::embeddable($url);
            if ($canEmbed === false) {
                $messages["detail_media.{$index}.youtube_url"] = __('admin.portfolio_youtube_not_embeddable');
            }
        }

        if ($messages !== []) {
            throw ValidationException::withMessages($messages);
        }
    }
}
