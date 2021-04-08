<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDuaSubTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dua_sub_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->bigInteger('dua_types_id')->unsigned()->index();
            $table->timestamps();
            $table->foreign('dua_types_id')
                ->references('id')
                ->on('dua_types')
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
        Schema::table('dua_sub_types', function ($table) {
            $table->dropForeign(['dua_types_id']);
            $table->dropColumn('dua_types_id');
        });
        Schema::dropIfExists('dua_sub_types');
    }
}
