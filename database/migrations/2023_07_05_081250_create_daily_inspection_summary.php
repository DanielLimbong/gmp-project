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
        Schema::create('daily_inspection_summaries', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at');
            $table->foreignId('user_id');
            $table->foreignId('area_id');
            $table->integer('score_total');
            $table->timestamp('updated_at');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_inspection_summaries');
    }
};
