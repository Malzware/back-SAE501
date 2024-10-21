<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Exécutez la migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Créé un champ 'id' comme clé primaire
            $table->string('lastname'); // Champ pour le nom de famille
            $table->string('firstname'); // Champ pour le prénom
            $table->string('email')->unique(); // Champ pour l'email, avec contrainte d'unicité
            $table->string('password'); // Champ pour le mot de passe
            $table->timestamps(); // Champs pour 'created_at' et 'updated_at'
        });
    }

    /**
     * Annulez la migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users'); // Supprime la table lors du rollback
    }
}
