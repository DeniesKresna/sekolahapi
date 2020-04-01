<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForecastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forecasts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
            $table->string('name')->nullable();
            $table->string('region')->nullable();
            $table->string('temp_c')->nullable();
            $table->string('condition_text')->nullable();
            $table->string('condition_icon')->nullable();
            $table->string('wind_kph')->nullable();
            $table->string('wind_dir')->nullable();
            $table->string('humidity')->nullable();
            $table->string('maxtemp_c_1')->nullable();
            $table->string('mintemp_c_1')->nullable();
            $table->string('condition_text_1')->nullable();
            $table->string('condition_icon_1')->nullable();
            $table->string('maxtemp_c_2')->nullable();
            $table->string('mintemp_c_2')->nullable();
            $table->string('condition_text_2')->nullable();
            $table->string('condition_icon_2')->nullable();
            $table->string('maxtemp_c_3')->nullable();
            $table->string('mintemp_c_3')->nullable();
            $table->string('condition_text_3')->nullable();
            $table->string('condition_icon_3')->nullable();
            $table->string('maxtemp_c_4')->nullable();
            $table->string('mintemp_c_4')->nullable();
            $table->string('condition_text_4')->nullable();
            $table->string('condition_icon_4')->nullable();
            $table->string('maxtemp_c_5')->nullable();
            $table->string('mintemp_c_5')->nullable();
            $table->string('condition_text_5')->nullable();
            $table->string('condition_icon_5')->nullable();
            $table->timestamp('initial_time');
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
        Schema::dropIfExists('forecasts');
    }
}
