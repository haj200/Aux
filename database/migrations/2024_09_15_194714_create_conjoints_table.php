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
        Schema::create('conjoints', function (Blueprint $table) {
            $table->id();
            $table->string('Nom_Fr');
            $table->string('Prenom_Fr');
            $table->string('Nom_Ar');
            $table->string('Prenom_Ar');
            $table->string('CNIE');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->foreignId('auxiliaire_id')->constrained('auxiliaires');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conjoints');
    }
};
