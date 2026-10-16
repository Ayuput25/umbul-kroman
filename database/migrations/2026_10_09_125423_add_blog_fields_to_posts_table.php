<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('posts', 'slug')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->string('slug')->nullable()->unique()->after('title');
            });
        }

        if (!Schema::hasColumn('posts', 'excerpt')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->text('excerpt')->nullable()->after('slug');
            });
        }

        if (!Schema::hasColumn('posts', 'content')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->longText('content')->nullable()->after('excerpt');
            });
        }

        if (!Schema::hasColumn('posts', 'image')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->string('image')->nullable()->after('content');
            });
        }

        if (!Schema::hasColumn('posts', 'is_published')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->boolean('is_published')->default(false)->after('image');
            });
        }

        if (!Schema::hasColumn('posts', 'published_at')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->timestamp('published_at')->nullable()->after('is_published');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('posts', 'published_at')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('published_at');
            });
        }

        if (Schema::hasColumn('posts', 'is_published')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('is_published');
            });
        }

        if (Schema::hasColumn('posts', 'image')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('image');
            });
        }

        if (Schema::hasColumn('posts', 'content')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('content');
            });
        }

        if (Schema::hasColumn('posts', 'excerpt')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('excerpt');
            });
        }

        if (Schema::hasColumn('posts', 'slug')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};