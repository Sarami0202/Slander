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
        Schema::create('lawyer_comments', function (Blueprint $table) {
            $table->id('lawyer_comment_id');
            $table->integer('slander_id');
            $table->integer('lawyer_id');
            $table->text('lawyer_comment');
            $table->dateTime('lawyer_comment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyer_comments');
    }
};