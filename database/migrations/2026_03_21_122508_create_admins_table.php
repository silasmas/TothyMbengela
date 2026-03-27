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
        Schema::create('admins', function (Blueprint $table) {
            $table->comment('Comptes d’administration Filament ; distincts des utilisateurs publics (garde session séparée).');
            $table->id()->comment('Identifiant unique de l’administrateur.');
            $table->string('name')->comment('Nom affiché dans le panel Filament.');
            $table->string('email')->unique()->comment('E-mail de connexion au panel admin.');
            $table->timestamp('email_verified_at')->nullable()->comment('Validation e-mail admin si activée.');
            $table->string('password')->comment('Mot de passe admin haché.');
            $table->rememberToken()->comment('Jeton « se souvenir de moi » pour la garde admin.');
            $table->timestamps();
        });

        Schema::create('admin_password_reset_tokens', function (Blueprint $table) {
            $table->comment('Réinitialisation mot de passe pour la table admins (séparée des utilisateurs site).');
            $table->string('email')->primary()->comment('E-mail de l’admin concerné.');
            $table->string('token')->comment('Jeton de reset envoyé par e-mail.');
            $table->timestamp('created_at')->nullable()->comment('Création du jeton.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_password_reset_tokens');
        Schema::dropIfExists('admins');
    }
};
