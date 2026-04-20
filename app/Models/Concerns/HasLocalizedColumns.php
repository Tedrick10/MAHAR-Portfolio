<?php

namespace App\Models\Concerns;

trait HasLocalizedColumns
{
    public function localized(string $base): string
    {
        $locale = app()->getLocale();
        $localizedKey = "{$base}_{$locale}";
        $value = $this->{$localizedKey} ?? null;

        if (is_string($value) && trim($value) !== '') {
            return $value;
        }

        if ($locale !== 'en') {
            $fallback = $this->{"{$base}_en"} ?? null;

            return is_string($fallback) ? $fallback : '';
        }

        return '';
    }
}
