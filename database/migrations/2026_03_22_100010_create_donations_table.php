<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->comment('Dons ponctuels ou réguliers au ministère ; traçabilité paiement et remerciements.');
            $table->id()->comment('Identifiant du don.');
            $table->string('donor_name')->nullable()->comment('Nom affiché si don non anonyme.');
            $table->string('donor_email')->nullable()->comment('E-mail pour reçu ou remerciement.');
            $table->string('donor_phone')->nullable()->comment('Téléphone pour SMS de confirmation si besoin.');
            $table->decimal('amount', 12, 2)->comment('Montant du don dans la devise indiquée.');
            $table->char('currency', 3)->default('USD')->comment('Devise ISO 4217.');
            $table->string('frequency')->default('once')->comment('once ou monthly selon engagement récurrent.');
            $table->boolean('is_anonymous')->default(false)->comment('Masquer l’identité sur les listes publiques éventuelles.');
            $table->text('message')->nullable()->comment('Mot ou prière laissé par le donateur.');
            $table->string('payment_provider')->nullable()->comment('Passerelle : stripe, m_pesa, orange_money, etc.');
            $table->string('external_payment_id')->nullable()->comment('ID transaction côté prestataire.');
            $table->string('status')->default('pending')->comment('pending, completed, failed, refunded.');
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
