<?php

namespace App\Support;

final class YoutubeEmbed
{
    /**
     * Extract an 11-character YouTube video id from common URL shapes (or bare id).
     */
    public static function videoIdFromUrl(string $url): ?string
    {
        $url = trim($url);
        if ($url === '') {
            return null;
        }

        if (preg_match('#^([a-zA-Z0-9_-]{11})$#', $url, $m)) {
            return $m[1];
        }

        if (preg_match('#[?&]v=([a-zA-Z0-9_-]{11})#', $url, $m)) {
            return $m[1];
        }

        if (preg_match('#youtu\.be/([a-zA-Z0-9_-]{11})#', $url, $m)) {
            return $m[1];
        }

        if (preg_match('#youtube\.com/embed/([a-zA-Z0-9_-]{11})#', $url, $m)) {
            return $m[1];
        }

        if (preg_match('#youtube\.com/shorts/([a-zA-Z0-9_-]{11})#', $url, $m)) {
            return $m[1];
        }

        if (preg_match('#youtube\.com/live/([a-zA-Z0-9_-]{11})#', $url, $m)) {
            return $m[1];
        }

        return null;
    }
}
