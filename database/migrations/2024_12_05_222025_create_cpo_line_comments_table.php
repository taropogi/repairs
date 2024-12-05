<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpoLineCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('cpo_line_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cpo_line_id')->constrained('cpo_lines')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('comment')->nullable();
            $table->string('commented_by'); // will get the current name of the user
            $table->timestamps();
            // Add unique constraint
            $table->unique(['cpo_line_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpo_line_comments');
    }
}
