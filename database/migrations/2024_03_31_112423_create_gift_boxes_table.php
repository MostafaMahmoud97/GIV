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
        Schema::create('gift_boxes', function (Blueprint $table) {
            $table->id();
            $table->string("box_name_en");
            $table->string("box_name_ar");
            $table->string("box_code");
            $table->double("price");
            $table->double("width");
            $table->double("height");
            $table->double("length");
            $table->boolean("is_active")->default(1);
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
        Schema::dropIfExists('gift_boxes');
    }
};
