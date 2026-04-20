<?php

namespace App\Support;

/**
 * TikTok comparison table cells are strings (yes/no) or localized arrays in config.
 * In the admin form we edit each cell as a single line: plain text, yes, no, or "EN | MY".
 */
final class MarketingServicesCellCodec
{
    public static function toFormValue(mixed $cell): string
    {
        if (is_array($cell)) {
            $en = (string) ($cell['en'] ?? '');
            $my = (string) ($cell['my'] ?? '');

            return trim($en.' | '.$my);
        }

        return (string) $cell;
    }

    public static function fromFormValue(string $value): mixed
    {
        $trimmed = trim($value);

        if ($trimmed === '') {
            return '';
        }

        if (strtolower($trimmed) === 'yes' || strtolower($trimmed) === 'no') {
            return strtolower($trimmed);
        }

        if (str_contains($trimmed, '|')) {
            [$en, $my] = array_pad(explode('|', $trimmed, 2), 2, '');

            return [
                'en' => trim($en),
                'my' => trim($my),
            ];
        }

        return $trimmed;
    }

    /**
     * @param  array<int, mixed>  $rows
     * @return array<int, mixed>
     */
    public static function flattenTiktokRows(array $rows): array
    {
        foreach ($rows as $i => $row) {
            if (! is_array($row)) {
                continue;
            }
            $cells = $row['cells'] ?? null;
            if (! is_array($cells)) {
                continue;
            }
            foreach ($cells as $j => $cell) {
                $rows[$i]['cells'][$j] = self::toFormValue($cell);
            }
        }

        return $rows;
    }

    /**
     * @param  array<int, mixed>  $rows
     * @return array<int, mixed>
     */
    public static function expandTiktokRows(array $rows): array
    {
        foreach ($rows as $i => $row) {
            if (! is_array($row)) {
                continue;
            }
            $cells = $row['cells'] ?? null;
            if (! is_array($cells)) {
                continue;
            }
            foreach ($cells as $j => $cell) {
                $rows[$i]['cells'][$j] = self::fromFormValue(is_string($cell) ? $cell : '');
            }
        }

        return $rows;
    }
}
