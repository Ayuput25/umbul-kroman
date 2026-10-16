<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {

            if (!Schema::hasColumn('site_settings', 'site_title')) {
                $table->string('site_title')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'meta_description')) {
                $table->text('meta_description')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'meta_keywords')) {
                $table->text('meta_keywords')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'favicon')) {
                $table->string('favicon')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'whatsapp_number')) {
                $table->string('whatsapp_number')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'whatsapp_message')) {
                $table->string('whatsapp_message')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'show_whatsapp')) {
                $table->boolean('show_whatsapp')->default(true);
            }

            if (!Schema::hasColumn('site_settings', 'instagram_url')) {
                $table->string('instagram_url')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'facebook_url')) {
                $table->string('facebook_url')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'tiktok_url')) {
                $table->string('tiktok_url')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'youtube_url')) {
                $table->string('youtube_url')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'footer_text')) {
                $table->string('footer_text')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {

            $columns = [
                'site_title',
                'meta_description',
                'meta_keywords',
                'favicon',
                'whatsapp_number',
                'whatsapp_message',
                'show_whatsapp',
                'instagram_url',
                'facebook_url',
                'tiktok_url',
                'youtube_url',
                'footer_text',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('site_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};