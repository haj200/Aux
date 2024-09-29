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
        Schema::create('auxiliaires', function (Blueprint $table) {
            $table->id();
            $table->string('Nom_Fr');
            $table->string('Prenom_Fr');
            $table->string('Nom_Ar');
            $table->string('Prenom_Ar');
            $table->string('Email');
            $table->string('Grade');
            $table->string('CNIE');
            $table->string('url_photo')->nullable();
            $table->string('RIB');
            $table->date('date_de_naissance');
            $table->date('date_de_recrutement');
            $table->enum('Type', ['rural', 'urbain']);
            $table->boolean('pensionne');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->foreignId('entiteterritorielle_id')->constrained('entiteterritorielles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auxiliaires');
    }
};
