<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->comment('Lignes de commande : quantité et prix figés au moment de l’achat.');
            $table->id()->comment('Identifiant de la ligne.');
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete()->comment('Commande parente.');
            $table->foreignId('book_id')->constrained('books')->restrictOnDelete()->comment('Livre vendu (restrict : pas suppression livre avec commandes).');
            $table->unsignedInteger('quantity')->default(1)->comment('Nombre d’unités achetées.');
            $table->decimal('unit_price', 12, 2)->comment('Prix unitaire au moment de la commande (historique).');
            $table->decimal('line_total', 12, 2)->comment('quantity × unit_price ; figé pour comptabilité.');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
