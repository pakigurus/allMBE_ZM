<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNonAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('non_announcements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('city_id')->nullable();
            $table->string('city_name')->nullable();
            $table->string('city_latitude')->nullable();
            $table->string('city_longitude')->nullable();
            $table->string('place_id')->nullable();
            $table->string('place_name')->nullable();
            $table->string('place_latitude')->nullable();
            $table->string('place_longitude')->nullable();
            $table->string('place_address')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('link')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('contact')->nullable();
            $table->string('message')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(false);
            $table->softDeletes();
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
        Schema::dropIfExists('non_announcements');
    }
}
