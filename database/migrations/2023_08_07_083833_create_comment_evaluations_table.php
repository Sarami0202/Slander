<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comment_evaluations', function (Blueprint $table) {
            $table->integer('comment_id');
            $table->integer('slander_id');
            $table->integer('type');
            $table->string('user_id');
            $table->dateTime('comment_evaluation_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_evaluations');
    }
};