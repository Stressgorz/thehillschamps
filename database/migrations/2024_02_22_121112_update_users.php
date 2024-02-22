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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('lack');
            $table->dropColumn('target1');
            $table->dropColumn('target2');
            $table->dropColumn('target3');
            $table->dropColumn('volume_daily');
            $table->dropColumn('volume_monthly');
            $table->dropColumn('volume_yearly');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar', 50)->nullable();
            $table->string('lack', 50)->nullable();
            $table->string('target1', 50)->nullable();
            $table->string('target2', 50)->nullable();
            $table->string('target3', 50)->nullable();
            $table->integer('volume_daily', 50)->nullable();
            $table->integer('volume_monthly', 50)->nullable();
            $table->integer('volume_yearly', 50)->nullable();
            $table->dropColumn('updated_at');
        });
    }
};
