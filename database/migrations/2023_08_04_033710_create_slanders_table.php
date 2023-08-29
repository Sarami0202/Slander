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
        Schema::create('slanders', function (Blueprint $table) {
            $table->id('slander_id');
            $table->text('img');
            $table->integer('platform');
            $table->text('title');
            $table->text('url');
            $table->string('victim');
            $table->string('perpetrator');
            $table->text('comment');
            $table->integer('view');
            $table->integer('connection');
            $table->dateTime('slander_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slanders');
    }
};