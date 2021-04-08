<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDuaDuaSubTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dua_dua_sub_types', function (Blueprint $table) {
            $table->bigIncrements('id');


            $table->bigInteger('dua_sub_types_id')->unsigned()->index();
            $table->bigInteger('duas_id')->unsigned()->index();

            // foreign keys

            $table->foreign('dua_sub_types_id')->references('id')->on('dua_sub_types')
                ->onDelete('cascade');
            $table->foreign('duas_id')->references('id')->on('duas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dua_dua_sub_types', function ($table) {
            $table->dropForeign(['dua_sub_types_id']);
            $table->dropForeign(['duas_id']);
            $table->dropColumn(['dua_sub_types_id', 'duas_id']);
        });
        Schema::dropIfExists('dua_dua_sub_types');
    }
}
