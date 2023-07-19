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
        Schema::create('daily_inspection', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daily_inspection_summary_id');
            $table->foreignId('question_id');
            $table->foreignId('answer_id');
            $table->integer('score_point');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_inspection');
    }
};
