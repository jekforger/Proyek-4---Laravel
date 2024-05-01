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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string("exercise_name");
            $table->string("time");
            $table->text("instructions");
            $table->unsignedBigInteger('set_type_id');
            $table->unsignedBigInteger('body_mass_standard_id');
            $table->timestamps();

            $table->foreign('set_type_id')->references('id')->on('set_types')->onDelete("cascade")->onUpdate("cascade");
            $table->foreign('body_mass_standard_id')->references('id')->on('body_mass_standards')->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
