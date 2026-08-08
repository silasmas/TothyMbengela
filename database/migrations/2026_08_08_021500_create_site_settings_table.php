<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Paramètres généraux du site (contact, slogan, réseaux sociaux).
 */
return new class extends Migration
{
    /**
     * Crée la table site_settings.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->comment('Coordonnées et identité publique du ministère.');
            $table->id();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('slogan')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('whatsapp_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Supprime la table site_settings.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
