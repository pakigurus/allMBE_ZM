<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSurrodateKeyColumInMasajidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('masajids', function (Blueprint $table) {
            $table->string('surrogate_id')->nullable();
            $table->boolean('non_masajid')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('masajids', function (Blueprint $table) {
            $table->dropColumn('surrogate_id');
            $table->dropColumn('non_masajid');
        });
    }
}
