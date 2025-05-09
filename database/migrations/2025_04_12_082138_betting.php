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
        Schema::create('bet', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('discord');
            $table->string('course');
            $table->string('ecurie');
            $table->integer('montant');
            $table->integer('paiement')->default(0);
            $table->integer('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bet');
    }
};
