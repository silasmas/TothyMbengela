<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->comment('File d’attente des jobs Laravel (queues database) en attente d’exécution.');
            $table->id()->comment('Identifiant du job en file.');
            $table->string('queue')->index()->comment('Nom de la queue cible (default, mails, etc.).');
            $table->longText('payload')->comment('Commande sérialisée et données du job.');
            $table->unsignedTinyInteger('attempts')->comment('Nombre de tentatives déjà effectuées.');
            $table->unsignedInteger('reserved_at')->nullable()->comment('Timestamp de prise en charge par un worker.');
            $table->unsignedInteger('available_at')->comment('Job exécutable à partir de ce timestamp.');
            $table->unsignedInteger('created_at')->comment('Timestamp de mise en file.');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->comment('Lots de jobs groupés (batch) pour suivi global de progression.');
            $table->string('id')->primary()->comment('UUID du lot.');
            $table->string('name')->comment('Nom descriptif du batch.');
            $table->integer('total_jobs')->comment('Nombre total de jobs du lot.');
            $table->integer('pending_jobs')->comment('Jobs encore en attente.');
            $table->integer('failed_jobs')->comment('Jobs en échec définitif.');
            $table->longText('failed_job_ids')->comment('Liste des IDs des jobs échoués.');
            $table->mediumText('options')->nullable()->comment('Options JSON du batch.');
            $table->integer('cancelled_at')->nullable()->comment('Annulation du lot si renseigné.');
            $table->integer('created_at')->comment('Création du lot.');
            $table->integer('finished_at')->nullable()->comment('Fin complète du lot.');
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->comment('Jobs définitivement en échec pour inspection et retry manuel.');
            $table->id()->comment('Identifiant interne de l’échec.');
            $table->string('uuid')->unique()->comment('UUID unique du job échoué.');
            $table->text('connection')->comment('Connexion queue utilisée.');
            $table->text('queue')->comment('Nom de la queue d’origine.');
            $table->longText('payload')->comment('Payload du job au moment de l’échec.');
            $table->longText('exception')->comment('Trace ou message d’exception.');
            $table->timestamp('failed_at')->useCurrent()->comment('Date/heure de l’échec.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};
