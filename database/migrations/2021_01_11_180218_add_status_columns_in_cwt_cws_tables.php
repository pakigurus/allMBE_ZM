<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusColumnsInCwtCwsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contribute_with_skills', function (Blueprint $table) {
           $table->boolean('status')->default(0);
        });
        Schema::table('contribute_with_times', function (Blueprint $table) {
            $table->boolean('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contribute_with_skills', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('contribute_with_times', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
