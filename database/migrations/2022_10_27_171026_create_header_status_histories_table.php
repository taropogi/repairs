<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeaderStatusHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('header_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cpo_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('header_status_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('note')->nullable();
            $table->foreignId('changed_by')
                ->references('id')
                ->on('users')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('header_status_histories');
    }
}