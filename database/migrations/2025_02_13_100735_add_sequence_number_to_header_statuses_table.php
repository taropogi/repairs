<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSequenceNumberToHeaderStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('header_statuses', function (Blueprint $table) {
            $table->integer('sequence_number')->nullable()->unique()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('header_statuses', function (Blueprint $table) {
            $table->dropColumn('sequence_number');
        });
    }
}
