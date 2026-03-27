<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pour les bases déjà migrées avant l’ajout des champs profil utilisateur,
     * des colonnes YouTube sur contents, et du lien user_id sur partner_commitments.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'phone')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('phone')->nullable()->after('password')->comment('Téléphone principal pour contact ou SMS (selon intégrations futures).');
                $table->string('whatsapp')->nullable()->after('phone')->comment('Numéro WhatsApp dédié (souvent format international sans espaces).');
                $table->string('country')->nullable()->after('whatsapp')->comment('Pays de résidence (libellé ou code pays selon le front).');
                $table->string('city')->nullable()->after('country')->comment('Ville de résidence.');
                $table->string('address_line')->nullable()->after('city')->comment('Ligne d’adresse postale (rue, numéro, complément).');
                $table->text('bio')->nullable()->after('address_line')->comment('Biographie courte ou témoignage affichable sur le profil public.');
                $table->string('avatar_path')->nullable()->after('bio')->comment('Chemin relatif ou disque du fichier image d’avatar (hors web public direct si stockage privé).');
                $table->string('preferred_locale', 10)->default('fr')->after('avatar_path')->comment('Code langue préféré pour l’interface (ex. fr, en).');
                $table->date('birthdate')->nullable()->after('preferred_locale')->comment('Date de naissance ; champ sensible, usage optionnel (pastoral, stats anonymisées).');
                $table->string('gender', 32)->nullable()->after('birthdate')->comment('Genre ou civilité déclarée ; valeur contrôlée côté application si besoin.');
            });
        }

        if (! Schema::hasColumn('contents', 'source')) {
            Schema::table('contents', function (Blueprint $table) {
                $table->string('source')->default('internal')->after('type')->comment('Origine du média : internal (fichier ou URL maison), youtube (lecture via API/embed), external (autre hébergeur).');
                $table->string('youtube_video_id', 32)->nullable()->after('media_url')->comment('Identifiant vidéo YouTube quand source=youtube ; sert aux embeds et oEmbed.');
                $table->string('youtube_url')->nullable()->after('youtube_video_id')->comment('URL canonique de la vidéo YouTube (watch ou youtu.be) pour lien « voir sur YouTube ».');
            });
        }

        if (Schema::hasColumn('partner_commitments', 'email')) {
            Schema::drop('partner_commitments');
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
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'phone')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn([
                    'phone', 'whatsapp', 'country', 'city', 'address_line', 'bio',
                    'avatar_path', 'preferred_locale', 'birthdate', 'gender',
                ]);
            });
        }

        if (Schema::hasColumn('contents', 'source')) {
            Schema::table('contents', function (Blueprint $table) {
                $table->dropColumn(['source', 'youtube_video_id', 'youtube_url']);
            });
        }
    }
};
