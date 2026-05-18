<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/**
 * Turns Google Maps share links (goo.gl, place URLs) into iframe-safe embed URLs.
 */
final class GoogleMapsUrlNormalizer
{
    private const BROWSER_USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';

    public static function looksLikeMapUrl(?string $value): bool
    {
        if ($value === null || trim($value) === '') {
            return true;
        }

        $value = strtolower(trim($value));

        return Str::contains($value, [
            'google.com/maps',
            'maps.google.com',
            'goo.gl/',
            'maps.app.goo.gl',
        ]);
    }

    public static function isEmbeddableInIframe(string $url): bool
    {
        $url = trim($url);

        // Only official /maps/embed URLs (not maps.google.com?...&output=embed — those show "Place info couldn't load").
        return str_contains($url, '/maps/embed');
    }

    public static function normalize(?string $input): ?string
    {
        if ($input === null || trim($input) === '') {
            return null;
        }

        $input = trim($input);

        if (preg_match('/src=["\']([^"\']+)["\']/i', $input, $iframe)) {
            $input = html_entity_decode($iframe[1], ENT_QUOTES);
        }

        if (self::isEmbedUrl($input)) {
            return $input;
        }

        $resolved = self::resolveFinalUrl($input) ?? $input;

        if (self::isEmbedUrl($resolved)) {
            return $resolved;
        }

        $pbEmbed = self::buildPbEmbedFromPlaceUrl($resolved);
        if ($pbEmbed !== null) {
            return $pbEmbed;
        }

        if (preg_match('/@(-?\d+(?:\.\d+)?),(-?\d+(?:\.\d+)?)/', $resolved, $coords)) {
            return self::buildPbEmbedFromCoordinates(
                (float) $coords[1],
                (float) $coords[2],
                self::placeNameFromUrl($resolved) ?? 'Location',
                null,
            );
        }

        if (preg_match('/[?&]q=([^&]+)/', $resolved, $query)) {
            $q = urldecode($query[1]);

            return self::buildPbEmbedFromCoordinates(0.0, 0.0, $q, null)
                ?? 'https://maps.google.com/maps?q='.rawurlencode($q).'&output=embed';
        }

        if (preg_match('#/place/([^/@?]+)#', $resolved, $place)) {
            $name = urldecode(str_replace('+', ' ', $place[1]));

            return 'https://maps.google.com/maps?q='.rawurlencode($name).'&output=embed';
        }

        return null;
    }

    private static function isEmbedUrl(string $url): bool
    {
        return str_contains($url, '/maps/embed')
            || str_contains($url, 'google.com/maps/embed');
    }

    private static function resolveFinalUrl(string $url): ?string
    {
        if (! str_starts_with($url, 'http://') && ! str_starts_with($url, 'https://')) {
            $url = 'https://'.$url;
        }

        try {
            $response = Http::timeout(12)
                ->connectTimeout(5)
                ->withHeaders(['User-Agent' => self::BROWSER_USER_AGENT])
                ->withOptions([
                    'allow_redirects' => ['max' => 10],
                ])
                ->get($url);

            $effective = method_exists($response, 'effectiveUri')
                ? $response->effectiveUri()
                : null;

            if ($effective !== null && ! str_contains((string) $effective, 'maps.app.goo.gl/')) {
                return (string) $effective;
            }

            $redirects = $response->handlerStats()['redirect_url'] ?? null;
            if (is_string($redirects) && $redirects !== '') {
                return $redirects;
            }

            if (is_array($redirects) && $redirects !== []) {
                return (string) end($redirects);
            }

            if ($response->successful() && str_contains($url, 'google.com/maps')) {
                return $url;
            }
        } catch (\Throwable) {
            return null;
        }

        return null;
    }

    private static function buildPbEmbedFromPlaceUrl(string $resolved): ?string
    {
        if (! preg_match('/!1s(0x[a-f0-9]+:0x[a-f0-9]+)/i', $resolved, $placeId)) {
            return null;
        }

        $lat = null;
        $lng = null;
        if (preg_match('/!3d(-?\d+(?:\.\d+)?)!4d(-?\d+(?:\.\d+)?)/', $resolved, $precise)) {
            $lat = (float) $precise[1];
            $lng = (float) $precise[2];
        } elseif (preg_match('/@(-?\d+(?:\.\d+)?),(-?\d+(?:\.\d+)?)/', $resolved, $at)) {
            $lat = (float) $at[1];
            $lng = (float) $at[2];
        }

        if ($lat === null || $lng === null) {
            return null;
        }

        $name = self::placeNameFromUrl($resolved) ?? 'Location';

        return self::buildPbEmbedFromCoordinates($lat, $lng, $name, $placeId[1]);
    }

    private static function placeNameFromUrl(string $url): ?string
    {
        if (! preg_match('#/place/([^/@?]+)#', $url, $match)) {
            return null;
        }

        return urldecode(str_replace('+', ' ', $match[1]));
    }

    private static function buildPbEmbedFromCoordinates(
        float $lat,
        float $lng,
        string $name,
        ?string $placeId,
    ): ?string {
        if ($lat === 0.0 && $lng === 0.0) {
            return null;
        }

        $zoom = 15;
        $scale = 2 ** (21 - $zoom);
        $d1 = $scale * 0.00025 * 111_320;
        $d2 = $scale * 0.00025 * 111_320 * cos(deg2rad($lat));
        $version = (int) (microtime(true) * 1000);

        $pb = '!1m18!1m12!1m3'
            .'!1d'.$d1
            .'!2d'.$d2
            .'!3d'.$lat
            .'!4d'.$lng
            .'!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2';

        if ($placeId !== null) {
            $pb .= '!1s'.$placeId;
        }

        $pb .= '!2s'.rawurlencode($name)
            .'!5e0!3m2!1sen!2smm!4v'.$version.'!5m2!1sen!2smm';

        return 'https://www.google.com/maps/embed?pb='.$pb;
    }
}
