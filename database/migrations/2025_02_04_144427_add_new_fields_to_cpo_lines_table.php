<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToCpoLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpo_lines', function (Blueprint $table) {
            $table->string('date_inspected')->nullable()->after('qty_inspect');
            $table->string('doc_date')->nullable()->after('hcopy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cpo_lines', function (Blueprint $table) {
            $table->dropColumn('date_inspected');
            $table->dropColumn('doc_date');
        });
    }
}
