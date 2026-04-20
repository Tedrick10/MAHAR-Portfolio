<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\Support\Htmlable;

class AdminDashboard extends BaseDashboard
{
    /**
     * Keep the default home URL and `filament.admin.pages.dashboard` route name.
     */
    protected static ?string $slug = 'dashboard';

    public static function getNavigationLabel(): string
    {
        return __('admin.topbar_dashboard');
    }

    public function getTitle(): string | Htmlable
    {
        return __('admin.dashboard_page_title');
    }

    /**
     * @return int | array<string, ?int>
     */
    public function getColumns(): int | array
    {
        return [
            'default' => 1,
            'xl' => 2,
        ];
    }
}
