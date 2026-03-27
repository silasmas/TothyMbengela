<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->comment('Inscrits newsletter / alertes nouveaux contenus (e-mail et option SMS).');
            $table->id()->comment('Identifiant de l’inscription.');
            $table->string('email')->unique()->comment('Adresse pour envoi des campagnes (clé métier).');
            $table->string('phone')->nullable()->comment('Numéro pour notifications SMS si intégration future.');
            $table->string('name')->nullable()->comment('Prénom ou nom pour personnalisation des envois.');
            $table->timestamp('verified_at')->nullable()->comment('Double opt-in : date de confirmation d’inscription.');
            $table->timestamp('unsubscribed_at')->nullable()->comment('Date de désinscription (RGPD / stop envoi).');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_subscribers');
    }
};
