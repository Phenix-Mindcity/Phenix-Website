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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->datetime('date')->nullable();
            $table->boolean('current');
        });

        DB::table("courses")->insert(["name" => "Rallye", "date" => NULL, "current" => 1]);
        DB::table("courses")->insert(["name" => "Ring Of Hell", "date" => NULL, "current" => 0]);
        DB::table("courses")->insert(["name" => "Street Race", "date" => NULL, "current" => 0]);
        DB::table("courses")->insert(["name" => "F1", "date" => NULL, "current" => 0]);
        DB::table("courses")->insert(["name" => "Truck", "date" => NULL, "current" => 0]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
