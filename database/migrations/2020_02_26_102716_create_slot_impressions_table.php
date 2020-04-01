<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlotImpressionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slot_impressions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imei')->nullable();
            $table->unsignedInteger('content_id')->nullable();
            $table->unsignedInteger('campaign_id')->nullable();
            $table->timestamp('play_start_time')->nullable();
            $table->timestamp('play_end_time')->nullable();
            $table->smallInteger('calculated_status')->default(0);
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
        Schema::dropIfExists('slot_impressions');
    }
}
