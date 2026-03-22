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
        Schema::table('sales', function (Blueprint $table) {
            $table->integer('funding')->after('broker_type')->nullable();
            $table->string('mt4_id')->nullable()->change();
            $table->string('mt4_pass')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('funding');
            $table->string('mt4_id')->nullable(false)->change();
            $table->string('mt4_pass')->nullable(false)->change();
        });
    }
};
