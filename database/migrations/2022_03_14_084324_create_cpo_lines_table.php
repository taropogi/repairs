<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpoLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpo_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cpo_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('line_number')->nullable();
            $table->string('description')->nullable();
            $table->string('comments')->nullable();
            $table->double('price', 8, 2)->nullable();
            $table->string('hcopy')->nullable();
            $table->integer('qty_returned')->nullable();
            $table->string('unit')->nullable();
            $table->integer('qty_inspect')->nullable();
            $table->integer('good_condition')->nullable();
            $table->integer('minor_repair_clean')->nullable();
            $table->integer('repair_parts_needed')->nullable();
            $table->integer('damaged')->nullable();
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
        Schema::dropIfExists('cpo_lines');
    }
}