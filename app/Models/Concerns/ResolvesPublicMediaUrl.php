<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait ResolvesPublicMediaUrl
{
    /**
     * Build a URL that works on any host/port (e.g. 127.0.0.1 vs localhost).
     * Avoids Storage::url() which prefixes APP_URL and breaks cross-host dev.
     */
    public static function publicMediaUrl(?string $path): ?string
    {
        if (! filled($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        $normalized = ltrim(str_replace('\\', '/', $path), '/');

        if (file_exists(public_path($normalized))) {
            return '/'.$normalized;
        }

        $onPublicDisk = storage_path('app/public/'.$normalized);
        if (is_file($onPublicDisk)) {
            return '/storage/'.$normalized;
        }

        // Avoid broken <img> URLs when uploads are missing or storage:link was not run on the server.
        return null;
    }
}
