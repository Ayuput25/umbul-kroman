<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('village_profiles', function (Blueprint $table) {
            $table->id();

            $table->string('name')->default('Umbul Kroman');
            $table->string('tagline')->nullable();

            $table->longText('description')->nullable();
            $table->longText('history')->nullable();
            $table->longText('vision')->nullable();
            $table->longText('mission')->nullable();

            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->text('google_maps_embed')->nullable();

            $table->string('logo')->nullable();
            $table->string('hero_image')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('village_profiles');
    }
};