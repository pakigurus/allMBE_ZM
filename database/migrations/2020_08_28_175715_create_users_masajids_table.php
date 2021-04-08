<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersMasajidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_masajids', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('users_id')->unsigned()->index();
            $table->bigInteger('masajids_id')->unsigned()->index();

            // foreign keys
            $table->foreign('users_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('masajids_id')->references('id')->on('masajids')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_masajids', function ($table) {
            $table->dropForeign(['users_id']);
            $table->dropForeign(['masajids_id']);
            $table->dropColumn(['users_id', 'masajids_id']);
        });
        Schema::dropIfExists('users_masajids');
    }
}
