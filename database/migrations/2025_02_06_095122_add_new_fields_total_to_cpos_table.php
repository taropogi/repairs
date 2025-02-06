<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsTotalToCposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpos', function (Blueprint $table) {
            $table->string('total_amount')->nullable();
            $table->string('total_qty_returned')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cpos', function (Blueprint $table) {
            $table->dropColumn('total_amount');
            $table->dropColumn('total_qty_returned');
        });
    }
}
