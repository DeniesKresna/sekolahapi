<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('creator_id')->nullable();
            $table->string('name')->nullable();
            $table->enum('gender',['male','female','none']);
            $table->string('plate_number',20)->nullable();
            $table->string('handphone',30)->nullable();
            //$table->string('car_type')->nullable();
            $table->string('ktp_number')->nullable();
            //$table->string('stnk')->nullable();
            $table->text('address')->nullable();
            $table->smallInteger('active');
            //$table->timestamp('dt_added');
            $table->timestamp('last_login');
            $table->string('one_signal_user_id')->nullable();
            //$table->string('led')->nullable();
            $table->smallInteger('registered')->default(0);
            $table->string('group',20)->nullable();
            //$table->string('car_color')->nullable();
            //$table->date('installation_date')->date();
            //$table->smallInteger('stnk_photo')->nullable();
            //$table->smallInteger('front_car_photo')->nullable();
            //$table->smallInteger('side_car_photo')->nullable();
            $table->smallInteger('driver_photo')->nullable();
            $table->string('tax')->nullable();
            $table->text('notes')->nullable();
            $table->double('last_lat',12,6)->nullable();
            $table->double('lats_lng',12,6)->nullable();
            $table->timestamp('last_gps_time');
            $table->double('total_km',20,2)->nullable();
            $table->integer('total_times')->nullable();
            $table->integer('total_points')->nullable();
            $table->smallInteger('system_connected')->nullable();
            $table->smallInteger('driver_connected')->nullable();
            $table->text('ktp_photo')->nullable();
            $table->text('customer_code')->nullable();
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
        Schema::dropIfExists('drivers');
    }
}
