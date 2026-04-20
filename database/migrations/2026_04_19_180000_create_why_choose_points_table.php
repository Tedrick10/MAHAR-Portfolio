<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('why_choose_points', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_my')->nullable();
            $table->text('body_en');
            $table->text('body_my')->nullable();
            $table->string('icon', 12)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('why_choose_points');
    }
};
