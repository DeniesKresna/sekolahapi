<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLayoutSequencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layout_sequences', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("content_id")->nullable();
            $table->unsignedInteger("layout_box_id")->nullable();
            $table->unsignedInteger("creator_id")->nullable();
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
        Schema::dropIfExists('layout_sequences');
    }
}
