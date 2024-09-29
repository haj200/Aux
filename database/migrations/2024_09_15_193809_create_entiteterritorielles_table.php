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
        Schema::create('entiteterritorielles', function (Blueprint $table) {
            $table->id();
            $table->string('Nom');
            $table->string('Nom_Ar');
            $table->enum('type', ['Province', 'Pachalik', 'Caidat', 'Cercle', 'Annexe']);
            $table->foreignId('managed_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entiteterritorielles');
    }
};
