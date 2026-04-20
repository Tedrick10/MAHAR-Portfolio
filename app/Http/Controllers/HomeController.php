<?php

namespace App\Http\Controllers;

use App\Models\CustomerReview;
use App\Models\DesignTool;
use App\Models\Faq;
use App\Models\Partner;
use App\Models\PortfolioItem;
use App\Models\WebsiteSetting;
use App\Models\WhyChoosePoint;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $settings = WebsiteSetting::current();
        $featured = PortfolioItem::published()->limit(6)->get();
        $designTools = DesignTool::published()->get();
        $partners = Partner::published()->get();
        $faqs = Faq::published()->limit(10)->get();
        $whyChoosePoints = WhyChoosePoint::published()->get();
        $customerReviews = CustomerReview::published()->get();

        return view('home', [
            'settings' => $settings,
            'featured' => $featured,
            'designTools' => $designTools,
            'partners' => $partners,
            'faqs' => $faqs,
            'whyChoosePoints' => $whyChoosePoints,
            'customerReviews' => $customerReviews,
        ]);
    }
}
