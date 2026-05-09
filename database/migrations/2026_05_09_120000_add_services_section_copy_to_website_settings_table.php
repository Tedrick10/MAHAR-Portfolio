<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds bilingual services-section copy columns. Safe to re-run if a previous attempt
 * partially applied (duplicate column errors on production).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('website_settings')) {
            return;
        }

        Schema::table('website_settings', function (Blueprint $table): void {
            // Use TEXT (not varchar(255)) so MySQL InnoDB stays under the ~65KB row-size limit with many nullable strings.
            if (! Schema::hasColumn('website_settings', 'services_lab_kicker_en')) {
                $table->text('services_lab_kicker_en')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_lab_kicker_my')) {
                $table->text('services_lab_kicker_my')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_heading_en')) {
                $table->text('services_heading_en')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_heading_my')) {
                $table->text('services_heading_my')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_intro_en')) {
                $table->text('services_intro_en')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_intro_my')) {
                $table->text('services_intro_my')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_cta_contact_en')) {
                $table->text('services_cta_contact_en')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_cta_contact_my')) {
                $table->text('services_cta_contact_my')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_facebook_kicker_en')) {
                $table->text('services_facebook_kicker_en')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_facebook_kicker_my')) {
                $table->text('services_facebook_kicker_my')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_facebook_title_en')) {
                $table->text('services_facebook_title_en')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_facebook_title_my')) {
                $table->text('services_facebook_title_my')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_fb_branding_heading_en')) {
                $table->text('services_fb_branding_heading_en')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_fb_branding_heading_my')) {
                $table->text('services_fb_branding_heading_my')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_fb_monthly_heading_en')) {
                $table->text('services_fb_monthly_heading_en')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_fb_monthly_heading_my')) {
                $table->text('services_fb_monthly_heading_my')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_package_script_en')) {
                $table->text('services_package_script_en')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_package_script_my')) {
                $table->text('services_package_script_my')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_tiktok_kicker_en')) {
                $table->text('services_tiktok_kicker_en')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_tiktok_kicker_my')) {
                $table->text('services_tiktok_kicker_my')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_tiktok_title_en')) {
                $table->text('services_tiktok_title_en')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_tiktok_title_my')) {
                $table->text('services_tiktok_title_my')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_tiktok_subtitle_en')) {
                $table->text('services_tiktok_subtitle_en')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_tiktok_subtitle_my')) {
                $table->text('services_tiktok_subtitle_my')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_tiktok_col_detail_en')) {
                $table->text('services_tiktok_col_detail_en')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_tiktok_col_detail_my')) {
                $table->text('services_tiktok_col_detail_my')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_tiktok_row_per_video_en')) {
                $table->text('services_tiktok_row_per_video_en')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_tiktok_row_per_video_my')) {
                $table->text('services_tiktok_row_per_video_my')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_tiktok_row_total_en')) {
                $table->text('services_tiktok_row_total_en')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_tiktok_row_total_my')) {
                $table->text('services_tiktok_row_total_my')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_download_pdf_en')) {
                $table->text('services_download_pdf_en')->nullable();
            }
            if (! Schema::hasColumn('website_settings', 'services_download_pdf_my')) {
                $table->text('services_download_pdf_my')->nullable();
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('website_settings')) {
            return;
        }

        $columns = [
            'services_lab_kicker_en',
            'services_lab_kicker_my',
            'services_heading_en',
            'services_heading_my',
            'services_intro_en',
            'services_intro_my',
            'services_cta_contact_en',
            'services_cta_contact_my',
            'services_facebook_kicker_en',
            'services_facebook_kicker_my',
            'services_facebook_title_en',
            'services_facebook_title_my',
            'services_fb_branding_heading_en',
            'services_fb_branding_heading_my',
            'services_fb_monthly_heading_en',
            'services_fb_monthly_heading_my',
            'services_package_script_en',
            'services_package_script_my',
            'services_tiktok_kicker_en',
            'services_tiktok_kicker_my',
            'services_tiktok_title_en',
            'services_tiktok_title_my',
            'services_tiktok_subtitle_en',
            'services_tiktok_subtitle_my',
            'services_tiktok_col_detail_en',
            'services_tiktok_col_detail_my',
            'services_tiktok_row_per_video_en',
            'services_tiktok_row_per_video_my',
            'services_tiktok_row_total_en',
            'services_tiktok_row_total_my',
            'services_download_pdf_en',
            'services_download_pdf_my',
        ];

        $existing = array_values(array_filter($columns, fn (string $c): bool => Schema::hasColumn('website_settings', $c)));

        if ($existing === []) {
            return;
        }

        Schema::table('website_settings', function (Blueprint $table) use ($existing): void {
            $table->dropColumn($existing);
        });
    }
};
