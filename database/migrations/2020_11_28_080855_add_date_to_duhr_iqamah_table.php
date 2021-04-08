<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateToDuhrIqamahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('duhr_iqamah', function (Blueprint $table) {
            $table->date('date')->after('time')->nullable();
        });
//        if (Schema::hasColumn('duhr_iqamah', 'to_date'))
//        {
//            Schema::table('duhr_iqamah', function (Blueprint $table)
//            {
//                $table->dropColumn('to_date');
//            });
//        }
//        if (Schema::hasColumn('duhr_iqamah', 'end_date'))
//        {
//            Schema::table('duhr_iqamah', function (Blueprint $table)
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
        Schema::table('duhr_iqamah', function (Blueprint $table) {
            //
        });
    }
}
