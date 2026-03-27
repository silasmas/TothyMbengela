<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->comment('Messages reçus via le formulaire de contact public.');
            $table->id()->comment('Identifiant du message.');
            $table->string('name')->comment('Nom de l’expéditeur.');
            $table->string('email')->comment('E-mail pour réponse.');
            $table->string('phone')->nullable()->comment('Téléphone optionnel.');
            $table->string('subject')->nullable()->comment('Sujet ou motif du message.');
            $table->text('body')->comment('Corps du message.');
            $table->boolean('is_read')->default(false)->comment('Lu ou non par l’équipe (file d’attente admin).');
            $table->timestamp('read_at')->nullable()->comment('Horodatage de première lecture.');
            $table->string('ip_address', 45)->nullable()->comment('IP source (modération / anti-spam).');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
