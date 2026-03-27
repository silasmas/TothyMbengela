<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partner_commitments', function (Blueprint $table) {
            $table->comment('Partenariats financiers : chaque engagement est lié à un compte users (inscription obligatoire avant statut partenaire).');
            $table->id()->comment('Identifiant de l’engagement partenaire.');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->comment('Utilisateur partenaire (données de profil : nom, e-mail, téléphone viennent de users).');
            $table->decimal('monthly_amount', 12, 2)->comment('Montant mensuel promis ou prélevé.');
            $table->char('currency', 3)->default('USD')->comment('Devise ISO 4217 du montant.');
            $table->text('message')->nullable()->comment('Mot du partenaire ou modalités particulières.');
            $table->string('status')->default('pending')->comment('pending, active, paused, ended, rejected.');
            $table->string('payment_reference')->nullable()->comment('Référence abonnement ou mandat chez le prestataire de paiement.');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_commitments');
    }
};
