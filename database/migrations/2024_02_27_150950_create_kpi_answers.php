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
        Schema::create('kpi_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInterger('kpi_id');
            $table->integer('sort');
            $table->text('name');
            $table->decimal('points', 20, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_answers');
    }
};