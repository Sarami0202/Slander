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
        Schema::create('lawyers', function (Blueprint $table) {
            $table->id("lawyer_id");
            $table->string('name');
            $table->string('mail');
            $table->string('pass');
            $table->string('tell');
            $table->integer('num');
            $table->string('url')->nullable();
            $table->string('img');
            $table->integer('license')->default(2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyers');
    }
};