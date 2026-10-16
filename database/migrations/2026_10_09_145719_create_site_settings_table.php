<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();

            $table->string('site_title')->nullable();

            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();

            $table->string('favicon')->nullable();

            $table->string('whatsapp_number')->nullable();
            $table->string('whatsapp_message')->nullable();
            $table->boolean('show_whatsapp')->default(true);

            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('youtube_url')->nullable();

            $table->string('footer_text')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};