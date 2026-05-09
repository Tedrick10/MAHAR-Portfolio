<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * InnoDB row format counts varchar columns toward the ~65KB row limit; many nullable varchar(255)s fill it.
 * TEXT is stored off-page — converting existing services_* columns frees space before adding any remaining ones.
 *
 * @see https://dev.mysql.com/doc/refman/8.0/en/column-count-limit.html
 */
return new class extends Migration
{
    /** @var list<string> */
    private const SERVICES_COPY_COLUMNS = [
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

    public function up(): void
    {
        if (! Schema::hasTable('website_settings')) {
            return;
        }

        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        foreach (self::SERVICES_COPY_COLUMNS as $column) {
            if (! Schema::hasColumn('website_settings', $column)) {
                continue;
            }

            DB::statement(sprintf(
                'ALTER TABLE `%s` MODIFY `%s` TEXT NULL',
                'website_settings',
                str_replace('`', '``', $column),
            ));
        }
    }

    public function down(): void
    {
        // Irreversible safely without knowing prior varchar lengths; leave as TEXT.
    }
};
