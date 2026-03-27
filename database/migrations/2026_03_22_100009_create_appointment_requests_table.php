<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointment_requests', function (Blueprint $table) {
            $table->comment('Demandes de rendez-vous avec la pasteure (prise de contact structurée).');
            $table->id()->comment('Identifiant de la demande.');
            $table->string('name')->comment('Nom du demandeur.');
            $table->string('email')->comment('E-mail de confirmation et suivi.');
            $table->string('phone')->comment('Téléphone pour rappel ou WhatsApp.');
            $table->date('preferred_date')->nullable()->comment('Date souhaitée par le visiteur.');
            $table->time('preferred_time')->nullable()->comment('Créneau horaire souhaité (fuseau à clarifier côté app).');
            $table->text('message')->comment('Motif ou message détaillé de la demande.');
            $table->string('status')->default('pending')->comment('pending, confirmed, cancelled, completed, etc.');
            $table->text('admin_notes')->nullable()->comment('Notes internes (disponibilités, décision).');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_requests');
    }
};
