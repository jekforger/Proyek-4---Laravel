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
        Schema::create('detail_achievements', function (Blueprint $table) {
            $table->id();
            $table->boolean("status");
            $table->unsignedBigInteger('achievement_id');
            $table->unsignedBigInteger('exercise_id');
            $table->timestamps();   

            $table->foreign('achievement_id')->references('id')->on('achievements')->onDelete("cascade")->onUpdate("cascade");
            $table->foreign('exercise_id')->references('id')->on('exercises')->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_achievements');
    }
};
