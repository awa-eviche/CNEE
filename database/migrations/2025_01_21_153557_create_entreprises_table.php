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
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->string("nomentreprise");
            $table->string("activite");
            $table->string("secteur");
            $table->string("nombreemployer");
            $table->string("tel");
            $table->string("region");
            $table->string("departement");
            $table->string("formj");
            $table->string("adresse");
            $table->string("email")->unique();
            $table->string("ninea")->unique();
            $table->string("regitcom")->unique();
            $table->boolean('est_actif')->default(true); 
            $table->string('statut')->default('en attente'); 
            $table->string("dossier");
            $table->string("quitus");
            $table->string("attestation");
            
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
        Schema::dropIfExists('entreprises');
    }
};
