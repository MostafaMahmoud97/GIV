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
        Schema::create('wrappings', function (Blueprint $table) {
            $table->id();
            $table->string("title_ar");
            $table->string("title_en");
            $table->string("code");
            $table->string("color");
            $table->string("material");
            $table->double("price_egy");
            $table->double("price_usd");
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
        Schema::dropIfExists('wrappings');
    }
};
