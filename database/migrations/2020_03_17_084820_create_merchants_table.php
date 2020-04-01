<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("creator_id")->nullable();
            $table->string("name",200)->nullable();
            $table->string("business_entity", 200)->nullable();
            $table->string("type_of_merchant",200)->nullable();
            $table->string("type_of_business",200)->nullable();
            $table->string("address",200)->nullable();
            $table->string("city",200)->nullable();
            $table->string("province",200)->nullable();
            $table->string("postal_code",200)->nullable();
            $table->string("phone_number",200)->nullable();
            $table->string("owner_name",200)->nullable();
            $table->string("bank_account_number",200)->nullable();
            $table->string("bank_account_name",200)->nullable();
            $table->string("photo_of_identity_card")->nullable();
            $table->string("photo_of_tax_id_number")->nullable();
            $table->string("photo_of_certificate")->nullable();
            $table->string("photo_of_proof_of_building_rent")->nullable();
            $table->string("photo_merchant_outside")->nullable();
            $table->string("photo_merchant_inside")->nullable();
            $table->string("photo_passbook")->nullable();
            $table->string("form_documentation_file")->nullable();
            $table->string('service_phone_number', 20)->nullable();
            $table->time('open_hour')->nullable();
            $table->time('close_hour')->nullable();
            $table->double('lng', 15, 8)->nullable();
            $table->double('lat', 15, 8)->nullable();
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
        Schema::dropIfExists('merchants');
    }
}
