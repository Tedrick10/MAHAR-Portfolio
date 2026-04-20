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
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\Widget;

class ContentShortcutsWidget extends Widget
{
    protected static ?int $sort = -25;

    /**
     * @var view-string
     */
    protected string $view = 'filament.widgets.content-shortcuts-widget';

    protected int | string | array $columnSpan = 'full';

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $unread = ContactMessage::query()->whereNull('read_at')->count();

        return [
            'groups' => [
                [
                    'title' => __('admin.dash_group_contact'),
                    'description' => __('admin.dash_group_contact_desc'),
                    'items' => [
                        [
                            'label' => ContactMessageResource::getNavigationLabel(),
                            'hint' => __('admin.shortcut_inbox_hint'),
                            'url' => ContactMessageResource::getUrl('index'),
                            'badge' => $unread > 0 ? (string) $unread : null,
                            'badgeColor' => 'warning',
                            'icon' => Heroicon::OutlinedInbox,
                        ],
                    ],
                ],
                [
                    'title' => __('admin.dash_group_content'),
                    'description' => __('admin.dash_group_content_desc'),
                    'items' => [
                        [
                            'label' => PortfolioItemResource::getNavigationLabel(),
                            'hint' => __('admin.shortcut_portfolio_hint'),
                            'url' => PortfolioItemResource::getUrl('index'),
                            'badge' => null,
                            'badgeColor' => null,
                            'icon' => Heroicon::OutlinedRectangleStack,
                        ],
                        [
                            'label' => FaqResource::getNavigationLabel(),
                            'hint' => __('admin.shortcut_faq_hint'),
                            'url' => FaqResource::getUrl('index'),
                            'badge' => null,
                            'badgeColor' => null,
                            'icon' => Heroicon::OutlinedQuestionMarkCircle,
                        ],
                        [
                            'label' => CustomerReviewResource::getNavigationLabel(),
                            'hint' => __('admin.shortcut_reviews_hint'),
                            'url' => CustomerReviewResource::getUrl('index'),
                            'badge' => null,
                            'badgeColor' => null,
                            'icon' => Heroicon::OutlinedStar,
                        ],
                        [
                            'label' => WhyChoosePointResource::getNavigationLabel(),
                            'hint' => __('admin.shortcut_why_hint'),
                            'url' => WhyChoosePointResource::getUrl('index'),
                            'badge' => null,
                            'badgeColor' => null,
                            'icon' => Heroicon::OutlinedSparkles,
                        ],
                        [
                            'label' => PartnerResource::getNavigationLabel(),
                            'hint' => __('admin.shortcut_partners_hint'),
                            'url' => PartnerResource::getUrl('index'),
                            'badge' => null,
                            'badgeColor' => null,
                            'icon' => Heroicon::OutlinedUserGroup,
                        ],
                        [
                            'label' => DesignToolResource::getNavigationLabel(),
                            'hint' => __('admin.shortcut_design_hint'),
                            'url' => DesignToolResource::getUrl('index'),
                            'badge' => null,
                            'badgeColor' => null,
                            'icon' => Heroicon::OutlinedSwatch,
                        ],
                    ],
                ],
                [
                    'title' => __('admin.dash_group_settings'),
                    'description' => __('admin.dash_group_settings_desc'),
                    'items' => [
                        [
                            'label' => WebsiteSettingResource::getNavigationLabel(),
                            'hint' => __('admin.shortcut_settings_hint'),
                            'url' => WebsiteSettingResource::getUrl('index'),
                            'badge' => null,
                            'badgeColor' => null,
                            'icon' => Heroicon::OutlinedCog6Tooth,
                        ],
                    ],
                ],
            ],
        ];
    }
}
