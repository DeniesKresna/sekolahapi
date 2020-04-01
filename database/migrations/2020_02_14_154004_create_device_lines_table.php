<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('device_id')->nullable();
            $table->unsignedInteger('box_id')->nullable(); 
            $table->unsignedInteger('car_id')->nullable();
            $table->unsignedInteger('driver_id')->nullable();
            $table->unsignedInteger('merchant_id')->nullable();
            $table->unsignedInteger('device_type_id')->nullable();
            $table->unsignedInteger('layout_id')->nullable();
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
        Schema::dropIfExists('device_lines');
    }
}
