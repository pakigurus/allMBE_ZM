<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFajrIqamahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fajr_iqamah', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('masajids_id')->unsigned()->index();

            // foreign keys
            $table->foreign('masajids_id')->references('id')->on('masajids')
                ->onDelete('cascade');

            $table->integer('user_id')->nullable();
            $table->string('user_email')->nullable();
            $table->boolean('status')->default(false);
            $table->time('time');
            $table->date('to_date');
            $table->date('end_date');
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

        Schema::table('fajr_iqamah', function ($table) {
            $table->dropForeign(['masajids_id']);
            $table->dropColumn('masajids_id');
        });


        Schema::dropIfExists('fajr_iqamah');
    }
}
