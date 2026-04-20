<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function __invoke(Request $request, string $locale): RedirectResponse
    {
        if (! in_array($locale, ['en', 'my'], true)) {
            $locale = 'en';
        }

        $request->session()->put('locale', $locale);

        $referer = $request->headers->get('referer');
        $host = $request->getHost();

        if ($referer && is_string(parse_url($referer, PHP_URL_HOST)) && parse_url($referer, PHP_URL_HOST) === $host) {
            return redirect()->to($referer);
        }

        return redirect()->route('home');
    }
}
