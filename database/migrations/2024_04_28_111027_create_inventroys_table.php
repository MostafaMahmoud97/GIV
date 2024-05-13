<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventroys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("value_one_id");
            $table->unsignedBigInteger("value_two_id")->default(0)->nullable();
            $table->unsignedBigInteger("value_three_id")->default(0)->nullable();
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("media_id")->default(0)->nullable();
            $table->string("value_title");
            $table->double("base_price_egy")->default(0);
            $table->double("price_instead_of_egy")->default(0);
            $table->double("base_price_usd")->default(0);
            $table->double("price_instead_of_usd")->default(0);
            $table->integer("available")->default(0);
            $table->integer("sold")->default(0);
            $table->integer("holding")->default(0);
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
        Schema::dropIfExists('inventroys');
    }
};
