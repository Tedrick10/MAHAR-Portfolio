<?php

namespace App\Filament\Resources\WebsiteSettings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class WebsiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Website settings')
                    ->persistTabInQueryString('tab')
                    ->tabs([
                        self::brandTab(),
                        self::heroTab(),
                        self::portfolioTab(),
                        WebsiteSettingFormServicesTab::make(),
                        self::contactTab(),
                        self::partnershipTab(),
                        self::faqTab(),
                        self::footerTab(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    private static function brandTab(): Tab
    {
        return Tab::make('Brand')
            ->icon(Heroicon::OutlinedPhoto)
            ->schema([
                Section::make('Site name')
                    ->description('Shown in the public header, footer, page titles, and Filament admin. Leave empty to use APP_NAME from your .env file.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('site_name_en')
                                    ->label('Site title (English)')
                                    ->maxLength(120),
                                TextInput::make('site_name_my')
                                    ->label('Site title (Myanmar)')
                                    ->maxLength(120),
                            ]),
                    ])
                    ->columns(1),
                Section::make('Logo & favicon')
                    ->description('Upload a logo for the public header/footer and a favicon for browser tabs. Leave empty to use the default letter mark and app icon.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                FileUpload::make('logo_path')
                                    ->label('Site logo')
                                    ->image()
                                    ->maxSize(2048)
                                    ->disk('public')
                                    ->directory('site-brand')
                                    ->imageEditor()
                                    ->visibility('public')
                                    ->helperText('PNG, JPG, WebP, or SVG. Transparent PNG works well on dark and light backgrounds.'),
                                FileUpload::make('favicon_path')
                                    ->label('Favicon')
                                    ->disk('public')
                                    ->directory('site-brand')
                                    ->visibility('public')
                                    ->acceptedFileTypes([
                                        'image/png',
                                        'image/jpeg',
                                        'image/webp',
                                        'image/svg+xml',
                                        'image/x-icon',
                                        'image/vnd.microsoft.icon',
                                    ])
                                    ->maxSize(512)
                                    ->helperText('Square image, typically 32×32 to 512×512. ICO or PNG recommended.'),
                            ]),
                    ])
                    ->columns(1),
            ]);
    }

    private static function heroTab(): Tab
    {
        return Tab::make('Hero')
            ->icon(Heroicon::OutlinedSparkles)
            ->schema([
                Section::make('Hero headline')
                    ->columns(2)
                    ->schema([
                        TextInput::make('hero_kicker_en')
                            ->label('Kicker (EN)'),
                        TextInput::make('hero_kicker_my')
                            ->label('Kicker (MY)'),
                        TextInput::make('hero_title_en')
                            ->label('Title (EN)'),
                        TextInput::make('hero_title_my')
                            ->label('Title (MY)'),
                    ]),
                Section::make('Hero intro')
                    ->columns(2)
                    ->schema([
                        Textarea::make('hero_subtitle_en')
                            ->label('Subtitle (EN)')
                            ->rows(5),
                        Textarea::make('hero_subtitle_my')
                            ->label('Subtitle (MY)')
                            ->rows(5),
                    ]),
                Section::make('Primary call to action')
                    ->columns(2)
                    ->schema([
                        TextInput::make('hero_cta_primary_label_en')
                            ->label('Button label (EN)'),
                        TextInput::make('hero_cta_primary_label_my')
                            ->label('Button label (MY)'),
                        TextInput::make('hero_cta_primary_url')
                            ->label('Button URL')
                            ->url()
                            ->columnSpanFull()
                            ->helperText('Leave empty to use the “Download CV” link: it serves the uploaded PDFs below (or falls back to public/cv.pdf if none are uploaded).'),
                    ]),
                Section::make('CV / profile PDFs')
                    ->description('Upload one or two PDFs. When the primary button URL is empty, visitors download from /cv — English locale uses the EN file first; Burmese uses the MY file when set, otherwise EN.')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('cv_pdf_en_path')
                            ->label('CV PDF (English / default)')
                            ->acceptedFileTypes(['application/pdf'])
                            ->disk('public')
                            ->directory('cv')
                            ->visibility('public')
                            ->maxSize(12288)
                            ->downloadable()
                            ->openable()
                            ->helperText('Shown for EN (and as fallback when no MY file).'),
                        FileUpload::make('cv_pdf_my_path')
                            ->label('CV PDF (Burmese, optional)')
                            ->acceptedFileTypes(['application/pdf'])
                            ->disk('public')
                            ->directory('cv')
                            ->visibility('public')
                            ->maxSize(12288)
                            ->downloadable()
                            ->openable()
                            ->helperText('Shown when the site is in MY. If empty, the EN file is used.'),
                    ]),
                Section::make('Secondary call to action')
                    ->columns(2)
                    ->schema([
                        TextInput::make('hero_cta_secondary_label_en')
                            ->label('Button label (EN)'),
                        TextInput::make('hero_cta_secondary_label_my')
                            ->label('Button label (MY)'),
                        TextInput::make('hero_cta_secondary_url')
                            ->label('Button URL')
                            ->url()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    private static function portfolioTab(): Tab
    {
        return Tab::make('Design')
            ->icon(Heroicon::OutlinedRectangleStack)
            ->schema([
                Section::make('Design section (homepage)')
                    ->columns(2)
                    ->schema([
                        TextInput::make('portfolio_heading_en')
                            ->label('Heading (EN)'),
                        TextInput::make('portfolio_heading_my')
                            ->label('Heading (MY)'),
                        Textarea::make('portfolio_intro_en')
                            ->label('Intro (EN)')
                            ->rows(4),
                        Textarea::make('portfolio_intro_my')
                            ->label('Intro (MY)')
                            ->rows(4),
                    ]),
            ]);
    }

    private static function contactTab(): Tab
    {
        return Tab::make('Contact')
            ->icon(Heroicon::OutlinedEnvelope)
            ->schema([
                Section::make('Contact section copy')
                    ->columns(2)
                    ->schema([
                        TextInput::make('contact_heading_en')
                            ->label('Heading (EN)'),
                        TextInput::make('contact_heading_my')
                            ->label('Heading (MY)'),
                        Textarea::make('contact_intro_en')
                            ->label('Intro (EN)')
                            ->rows(4),
                        Textarea::make('contact_intro_my')
                            ->label('Intro (MY)')
                            ->rows(4),
                    ]),
                Section::make('Contact details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('contact_email')
                            ->label('Email')
                            ->email()
                            ->columnSpan(1),
                        TextInput::make('contact_phone')
                            ->label('Phone')
                            ->tel()
                            ->columnSpan(1),
                        Textarea::make('contact_address_en')
                            ->label('Address (EN)')
                            ->rows(3),
                        Textarea::make('contact_address_my')
                            ->label('Address (MY)')
                            ->rows(3),
                        TextInput::make('contact_hours_en')
                            ->label('Hours (EN)'),
                        TextInput::make('contact_hours_my')
                            ->label('Hours (MY)'),
                    ]),
            ]);
    }

    private static function partnershipTab(): Tab
    {
        return Tab::make('Partnership')
            ->icon(Heroicon::OutlinedUserGroup)
            ->schema([
                Section::make('Partnership block')
                    ->columns(2)
                    ->schema([
                        TextInput::make('partnership_heading_en')
                            ->label('Heading (EN)'),
                        TextInput::make('partnership_heading_my')
                            ->label('Heading (MY)'),
                        Textarea::make('partnership_body_en')
                            ->label('Body (EN)')
                            ->rows(5),
                        Textarea::make('partnership_body_my')
                            ->label('Body (MY)')
                            ->rows(5),
                    ]),
            ]);
    }

    private static function faqTab(): Tab
    {
        return Tab::make('FAQ')
            ->icon(Heroicon::OutlinedQuestionMarkCircle)
            ->schema([
                Section::make('FAQ section')
                    ->columns(2)
                    ->schema([
                        TextInput::make('faq_heading_en')
                            ->label('Heading (EN)'),
                        TextInput::make('faq_heading_my')
                            ->label('Heading (MY)'),
                        Textarea::make('faq_intro_en')
                            ->label('Intro (EN)')
                            ->rows(4),
                        Textarea::make('faq_intro_my')
                            ->label('Intro (MY)')
                            ->rows(4),
                    ]),
            ]);
    }

    private static function footerTab(): Tab
    {
        return Tab::make('Footer & social')
            ->icon(Heroicon::OutlinedGlobeAlt)
            ->schema([
                Section::make('Footer text')
                    ->columns(2)
                    ->schema([
                        TextInput::make('footer_tagline_en')
                            ->label('Tagline (EN)'),
                        TextInput::make('footer_tagline_my')
                            ->label('Tagline (MY)'),
                        TextInput::make('footer_copyright_en')
                            ->label('Copyright line (EN)'),
                        TextInput::make('footer_copyright_my')
                            ->label('Copyright line (MY)'),
                    ]),
                Section::make('Social links')
                    ->description('Full URLs including https://')
                    ->columns(2)
                    ->schema([
                        TextInput::make('social_facebook')
                            ->label('Facebook')
                            ->url(),
                        TextInput::make('social_telegram')
                            ->label('Telegram')
                            ->url(),
                        TextInput::make('social_viber')
                            ->label('Viber')
                            ->url(),
                        TextInput::make('social_tiktok')
                            ->label('TikTok')
                            ->url(),
                    ]),
            ]);
    }
}
