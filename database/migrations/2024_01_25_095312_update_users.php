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
            $table->string('code',20)->after('name');
            $table->string('ib_code',20)->after('code');
            $table->string('contact',20)->after('email');
            $table->string('dob')->after('contact');
            $table->bigInteger('team_id')->after('role')->unsigned();
            $table->bigInteger('position_id')->after('team_id')->unsigned();
            $table->bigInteger('upline_id')->after('role')->unsigned();

            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('position_id')->references('id')->on('positions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropForeign(['position_id']);
            
            $table->dropColumn('code');
            $table->dropColumn('ib_code');
            $table->dropColumn('team_id');
            $table->dropColumn('position_id');
            $table->dropColumn('upline_id');
        });
    }
};
