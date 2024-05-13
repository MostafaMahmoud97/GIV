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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("title_en");
            $table->string("title_ar");
            $table->string("code")->default("")->nullable();
            $table->longText("description_ar");
            $table->longText("description_en");
            $table->double("main_price_egy");
            $table->double("main_price_usd");
            $table->double("main_instead_of_egy")->default(0)->nullable();
            $table->double("main_instead_of_usd")->default(0)->nullable();
            $table->boolean("is_active")->default(1);
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
        Schema::dropIfExists('products');
    }
};
