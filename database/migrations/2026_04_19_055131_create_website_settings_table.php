<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();

            $table->string('hero_kicker_en')->nullable();
            $table->string('hero_kicker_my')->nullable();
            $table->string('hero_title_en')->nullable();
            $table->string('hero_title_my')->nullable();
            $table->text('hero_subtitle_en')->nullable();
            $table->text('hero_subtitle_my')->nullable();
            $table->string('hero_cta_primary_label_en')->nullable();
            $table->string('hero_cta_primary_label_my')->nullable();
            $table->string('hero_cta_primary_url')->nullable();
            $table->string('hero_cta_secondary_label_en')->nullable();
            $table->string('hero_cta_secondary_label_my')->nullable();
            $table->string('hero_cta_secondary_url')->nullable();

            $table->string('portfolio_heading_en')->nullable();
            $table->string('portfolio_heading_my')->nullable();
            $table->text('portfolio_intro_en')->nullable();
            $table->text('portfolio_intro_my')->nullable();

            $table->string('contact_heading_en')->nullable();
            $table->string('contact_heading_my')->nullable();
            $table->text('contact_intro_en')->nullable();
            $table->text('contact_intro_my')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('contact_address_en')->nullable();
            $table->text('contact_address_my')->nullable();

            $table->string('partnership_heading_en')->nullable();
            $table->string('partnership_heading_my')->nullable();
            $table->text('partnership_body_en')->nullable();
            $table->text('partnership_body_my')->nullable();

            $table->string('faq_heading_en')->nullable();
            $table->string('faq_heading_my')->nullable();
            $table->text('faq_intro_en')->nullable();
            $table->text('faq_intro_my')->nullable();

            $table->string('footer_tagline_en')->nullable();
            $table->string('footer_tagline_my')->nullable();
            $table->string('footer_copyright_en')->nullable();
            $table->string('footer_copyright_my')->nullable();
            $table->string('social_instagram')->nullable();
            $table->string('social_behance')->nullable();
            $table->string('social_dribbble')->nullable();
            $table->string('social_linkedin')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};
