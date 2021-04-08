<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateToFajrIqamahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fajr_iqamah', function (Blueprint $table) {
            $table->date('date')->after('time')->nullable();
        });
//        if (Schema::hasColumn('fajr_iqamah', 'to_date'))
//        {
//            Schema::table('fajr_iqamah', function (Blueprint $table)
//            {
//                $table->dropColumn('to_date');
//            });
//        }
//        if (Schema::hasColumn('fajr_iqamah', 'end_date'))
//        {
//            Schema::table('fajr_iqamah', function (Blueprint $table)
//            {
//                $table->dropColumn('end_date');
//            });
//        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fajr_iqamah', function (Blueprint $table) {
            //
        });
    }
}
