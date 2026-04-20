<?php

namespace App\Http\Controllers;

use App\Models\WebsiteSetting;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CvDownloadController extends Controller
{
    public function __invoke(): BinaryFileResponse
    {
        $settings = WebsiteSetting::current();

        $path = $settings->cvAbsolutePathForDownload();

        if ($path === null) {
            $path = public_path('cv.pdf');
        }

        abort_unless(is_file($path), 404);

        return response()->download(
            $path,
            $settings->cvDownloadBaseName(),
            ['Content-Type' => 'application/pdf']
        );
    }
}
