<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->comment('Commandes librairie ; liées à un utilisateur connecté ou à un invité (e-mail / téléphone).');
            $table->id()->comment('Numéro interne de commande.');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->comment('Acheteur connecté ; null si achat invité.');
            $table->string('guest_email')->nullable()->comment('E-mail de l’invité pour envoi facture / lien de téléchargement.');
            $table->string('guest_phone')->nullable()->comment('Téléphone invité pour suivi ou Mobile Money.');
            $table->string('status')->default('pending')->comment('État métier : pending, paid, cancelled, refunded, etc.');
            $table->decimal('subtotal', 12, 2)->comment('Total articles avant frais éventuels (livraison, taxes).');
            $table->char('currency', 3)->default('USD')->comment('Devise de la commande (ISO 4217).');
            $table->string('payment_status')->default('pending')->comment('État du paiement : pending, completed, failed.');
            $table->string('payment_method')->nullable()->comment('Moyen utilisé : card, m_pesa, orange_money, etc.');
            $table->string('payment_reference')->nullable()->comment('Référence fournie par le prestataire de paiement.');
            $table->text('notes')->nullable()->comment('Remarques client ou internes (logistique).');
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
