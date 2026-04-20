<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use App\Filament\Resources\CustomerReviews\CustomerReviewResource;
use App\Filament\Resources\DesignTools\DesignToolResource;
use App\Filament\Resources\Faqs\FaqResource;
use App\Filament\Resources\Partners\PartnerResource;
use App\Filament\Resources\PortfolioItems\PortfolioItemResource;
use App\Filament\Resources\WebsiteSettings\WebsiteSettingResource;
use App\Filament\Resources\WhyChoosePoints\WhyChoosePointResource;
use App\Models\ContactMessage;
use App\Models\CustomerReview;
use App\Models\DesignTool;
use App\Models\Faq;
use App\Models\Partner;
use App\Models\PortfolioItem;
use App\Models\WebsiteSetting;
use App\Models\WhyChoosePoint;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SiteOverviewStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = -30;

    protected ?string $pollingInterval = '30s';

    /**
     * Fewer columns on narrow viewports so stat titles do not truncate on tablets.
     *
     * @var int | array<string, int | null> | null
     */
    protected int | array | null $columns = [
        'default' => 1,
        'sm' => 2,
        'lg' => 3,
        'xl' => 4,
    ];

    protected function getHeading(): ?string
    {
        return __('admin.dashboard_stats_heading');
    }

    protected function getDescription(): ?string
    {
        return __('admin.dashboard_stats_description');
    }

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        $unread = ContactMessage::query()->whereNull('read_at')->count();
        $messagesTotal = ContactMessage::query()->count();

        return [
            Stat::make(__('admin.stat_inbox'), $messagesTotal)
                ->description(__('admin.stat_inbox_unread', ['count' => $unread]))
                ->descriptionIcon($unread > 0 ? Heroicon::OutlinedEnvelope : Heroicon::OutlinedCheckCircle)
                ->descriptionColor($unread > 0 ? 'warning' : 'success')
                ->icon(Heroicon::OutlinedInbox)
                ->color('primary')
                ->url(ContactMessageResource::getUrl('index')),
            Stat::make(__('admin.stat_portfolio'), PortfolioItem::query()->count())
                ->description(__('admin.stat_portfolio_hint'))
                ->icon(Heroicon::OutlinedRectangleStack)
                ->color('gray')
                ->url(PortfolioItemResource::getUrl('index')),
            Stat::make(__('admin.stat_faq'), Faq::query()->count())
                ->description(__('admin.stat_faq_hint'))
                ->icon(Heroicon::OutlinedQuestionMarkCircle)
                ->color('gray')
                ->url(FaqResource::getUrl('index')),
            Stat::make(__('admin.stat_reviews'), CustomerReview::query()->count())
                ->description(__('admin.stat_reviews_hint'))
                ->icon(Heroicon::OutlinedStar)
                ->color('gray')
                ->url(CustomerReviewResource::getUrl('index')),
            Stat::make(__('admin.stat_partners'), Partner::query()->count())
                ->description(__('admin.stat_partners_hint'))
                ->icon(Heroicon::OutlinedUserGroup)
                ->color('gray')
                ->url(PartnerResource::getUrl('index')),
            Stat::make(__('admin.stat_design_tools'), DesignTool::query()->count())
                ->description(__('admin.stat_design_tools_hint'))
                ->icon(Heroicon::OutlinedSwatch)
                ->color('gray')
                ->url(DesignToolResource::getUrl('index')),
            Stat::make(__('admin.stat_why_choose'), WhyChoosePoint::query()->count())
                ->description(__('admin.stat_why_choose_hint'))
                ->icon(Heroicon::OutlinedSparkles)
                ->color('gray')
                ->url(WhyChoosePointResource::getUrl('index')),
            Stat::make(__('admin.stat_site_settings'), WebsiteSetting::query()->count())
                ->description(__('admin.stat_site_settings_hint'))
                ->icon(Heroicon::OutlinedCog6Tooth)
                ->color('gray')
                ->url(WebsiteSettingResource::getUrl('index')),
        ];
    }
}
