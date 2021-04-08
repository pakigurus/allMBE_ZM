<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedANeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_a_needs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('masajids_id')->unsigned()->index()->nullable();
            $table->foreign('masajids_id')->references('id')->on('masajids')
                ->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('ntn')->nullable();
            $table->string('amount')->nullable();
            $table->boolean('focal_person')->default(false);
            $table->text('description')->nullable();
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

        Schema::table('feed_a_needs', function ($table) {
            $table->dropForeign(['masajids_id']);
            $table->dropColumn(['masajids_id']);
        });
        Schema::dropIfExists('feed_a_needs');
    }
}
