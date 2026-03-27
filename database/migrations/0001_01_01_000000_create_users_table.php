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
        Schema::create('users', function (Blueprint $table) {
            $table->comment('Comptes publics : fidèles, acheteurs en librairie ; un partenaire doit posséder un compte ici avant tout engagement.');
            $table->id()->comment('Identifiant unique du compte utilisateur.');
            $table->string('name')->comment('Nom complet utilisé sur le profil, les commandes et les messages.');
            $table->string('email')->unique()->comment('Adresse e-mail de connexion (Breeze) et de contact.');
            $table->timestamp('email_verified_at')->nullable()->comment('Horodatage de validation de l’e-mail si la vérification est activée.');
            $table->string('password')->comment('Hachage du mot de passe (bcrypt/argon) ; jamais stocké en clair.');
            $table->string('phone')->nullable()->comment('Téléphone principal pour contact ou SMS (selon intégrations futures).');
            $table->string('whatsapp')->nullable()->comment('Numéro WhatsApp dédié (souvent format international sans espaces).');
            $table->string('country')->nullable()->comment('Pays de résidence (libellé ou code pays selon le front).');
            $table->string('city')->nullable()->comment('Ville de résidence.');
            $table->string('address_line')->nullable()->comment('Ligne d’adresse postale (rue, numéro, complément).');
            $table->text('bio')->nullable()->comment('Biographie courte ou témoignage affichable sur le profil public.');
            $table->string('avatar_path')->nullable()->comment('Chemin relatif ou disque du fichier image d’avatar (hors web public direct si stockage privé).');
            $table->string('preferred_locale', 10)->default('fr')->comment('Code langue préféré pour l’interface (ex. fr, en).');
            $table->date('birthdate')->nullable()->comment('Date de naissance ; champ sensible, usage optionnel (pastoral, stats anonymisées).');
            $table->string('gender', 32)->nullable()->comment('Genre ou civilité déclarée ; valeur contrôlée côté application si besoin.');
            $table->rememberToken()->comment('Jeton opaque pour l’option « se souvenir de cet appareil ».');
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->comment('Jetons de réinitialisation de mot de passe pour les utilisateurs (file d’attente e-mail).');
            $table->string('email')->primary()->comment('E-mail du compte concerné ; clé primaire logique.');
            $table->string('token')->comment('Jeton signé ou hashé envoyé par lien dans l’e-mail.');
            $table->timestamp('created_at')->nullable()->comment('Date de création du jeton (expiration gérée par l’application).');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->comment('Sessions HTTP stockées en base (driver database) pour utilisateurs et invités.');
            $table->string('id')->primary()->comment('Identifiant de session côté cookie.');
            $table->foreignId('user_id')->nullable()->index()->comment('Utilisateur authentifié associé à la session, si connecté.');
            $table->string('ip_address', 45)->nullable()->comment('Adresse IP du client lors de la dernière activité.');
            $table->text('user_agent')->nullable()->comment('En-tête User-Agent du navigateur ou appareil.');
            $table->longText('payload')->comment('Données sérialisées de la session.');
            $table->integer('last_activity')->index()->comment('Timestamp Unix de la dernière activité (expiration / nettoyage).');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
