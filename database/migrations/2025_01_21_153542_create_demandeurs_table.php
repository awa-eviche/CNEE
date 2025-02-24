<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demandeurs', function (Blueprint $table) {
            $table->id();
            $table->string("nom");
            $table->string("prenom");
            $table->string("sexe");
            $table->string("datenaissance");
            $table->string("lieunaissance");
            $table->string("adresse");
            $table->string("region");
            $table->string("departement");
            $table->string("email")->unique();
            $table->string("cni")->unique();
            $table->string("tel")->unique();
            $table->foreignId('niveaux_id')->constrained()->nullable();
            $table->foreignId('profil_id')->constrained()->nullable();
            $table->string("cv");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demandeurs');
    }
};
