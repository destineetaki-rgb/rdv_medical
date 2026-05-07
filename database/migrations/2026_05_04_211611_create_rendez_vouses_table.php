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
    public function up(): void
{
    Schema::create('rendez_vous', function (Blueprint $table) {
        $table->id();
        $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
        $table->foreignId('medecin_id')->constrained()->cascadeOnDelete();
        $table->date('date');
        $table->time('heure');
        $table->string('motif');
        $table->string('statut')->default('planifié');
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
        Schema::dropIfExists('rendez_vouses');
    }
};
