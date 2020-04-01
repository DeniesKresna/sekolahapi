<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('driver_id')->nullable();
            $table->unsignedInteger('box_id')->nullable();
            $table->unsignedInteger('creator_id')->nullable();
            $table->string('plate_number');
            $table->string('stnk')->nullable();
            $table->string('car_type')->nullable();
            $table->string('car_color')->nullable();
            $table->date('installation_date');
            $table->text('stnk_photo')->nullable();
            $table->text('front_car_photo')->nullable();
            $table->text('side_car_photo')->nullable();
            $table->text('vehicle_type')->nullable();
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
        Schema::dropIfExists('cars');
    }
}
