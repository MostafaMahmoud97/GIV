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
        Schema::create('business_requests', function (Blueprint $table) {
            $table->id();
            $table->string("store_name");
            $table->integer("no_branches")->default(0);
            $table->string("store_type")->default("")->nullable();
            $table->string("website")->default("")->nullable();
            $table->longText("store_address")->default("")->nullable();
            $table->string("first_name");
            $table->string("last_name");
            $table->string("phone_number");
            $table->string("email");
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
        Schema::dropIfExists('business_requests');
    }
};
