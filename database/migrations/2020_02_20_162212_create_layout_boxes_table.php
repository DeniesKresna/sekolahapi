<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLayoutBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layout_boxes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('layout_id')->nullable();
            $table->string('lemma_publisher_id',20)->nullable();
            $table->string('lemma_ads_unit_id')->nullable();
            $table->integer('box_number');
            $table->integer('timeout');
            $table->string('data_type');
            //$table->integer('start')->nullable();
            //$table->integer('size')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('align_parent_end',10)->nullable();
            $table->string('align_parent_top',10)->nullable();
            $table->string('align_parent_bottom',10)->nullable();
            $table->integer('below')->nullable();
            $table->integer('right_of')->nullable();
            $table->integer('left_of')->nullable();
            $table->integer('font_size')->nullable();
            $table->smallInteger('enable_slotting')->default(0);
            $table->unsignedInteger('creator_id')->nullable();
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
        Schema::dropIfExists('layout_boxes');
    }
}
