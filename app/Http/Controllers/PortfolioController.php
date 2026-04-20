<?php

namespace App\Http\Controllers;

use App\Models\PortfolioItem;
use App\Models\WebsiteSetting;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $settings = WebsiteSetting::current();
        $items = PortfolioItem::published()->get();

        return view('portfolio.index', [
            'settings' => $settings,
            'items' => $items,
        ]);
    }

    public function show(string $slug): View
    {
        $item = PortfolioItem::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('portfolio.show', [
            'item' => $item,
            'galleryUrls' => $item->detailGalleryUrls(),
        ]);
    }
}
