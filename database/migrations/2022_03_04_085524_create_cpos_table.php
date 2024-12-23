<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpos', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('rpo_number')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('authorized_by')->nullable();
            $table->string('oracle_customer_id')->nullable();
            $table->string('oracle_customer_shipto')->nullable();
            $table->boolean('locked')->default(false);
            $table->softDeletes();
            /*
            add fk migration
            $table->foreignId('status')->references('id')->on('header_statuses')->constrained()->onUpdate('cascade')->onDelete('cascade');
*/
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
        Schema::dropIfExists('cpos');
    }
}