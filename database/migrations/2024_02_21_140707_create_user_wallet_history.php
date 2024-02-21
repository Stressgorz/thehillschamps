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
        Schema::create('user_wallet_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('transaction_type', 20);
            $table->bigInteger('transaction_id');
            $table->string('wallet', 20);
            $table->decimal('prev_balance', 20, 2);
            $table->string('type', 20);
            $table->decimal('amount', 20, 2);
            $table->decimal('balance', 20, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_wallet_history');
    }
};
