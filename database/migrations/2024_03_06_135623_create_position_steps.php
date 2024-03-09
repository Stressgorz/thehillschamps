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
        Schema::create('position_steps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('position_id');
            $table->integer('sort');
            $table->string('name', 251)->nullable();
            $table->integer('amount')->nullable();
            $table->text('image')->nullable();
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('position_steps');
    }
};
