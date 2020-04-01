<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('imei',50);
            $table->string('sim_card_no')->nullable();
            $table->string('sim_card_serial')->nullable();
            $table->smallInteger('active')->nullable();
            $table->string('monitor')->nullable();
            $table->timestamp('last_gps_time')->nullable();
            $table->timestamp('last_screen_time')->nullable();
            $table->timestamp('last_screen_off_time')->nullable();
            $table->double('total_distance',20,2)->nullable();
            $table->bigInteger('total_screen_time')->nullable();
            $table->double('total_park_time')->nullable();
            $table->enum('screen_status',['off','on'])->default('off');
            $table->double('last_lat',12,6)->nullable();
            $table->double('last_lng',12,6)->nullable();
            $table->unsignedInteger('driver_id')->nullable();
            $table->smallInteger('troubled')->nullable();
            $table->unsignedInteger('box_id')->nullable();
            $table->unsignedInteger('location_id')->nullable();
            $table->text('comment')->nullable();
            $table->unsignedInteger('device_type_id')->nullable();
            $table->unsignedInteger('device_group_id')->nullable();
            $table->string('app_version')->nullable();
            $table->smallInteger('download_status')->default(0);
            $table->unsignedInteger('creator_id')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('devices');
    }
}
