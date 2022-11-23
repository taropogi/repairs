<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpoPdfHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpo_pdf_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cpo_id')
                ->constrained()
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('created_by')->references('id')->on('users')
                ->constrained()
                ->onDelete('cascade')->onUpdate('cascade');
            $table->string('file_name');

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
        Schema::dropIfExists('cpo_pdf_histories');
    }
}