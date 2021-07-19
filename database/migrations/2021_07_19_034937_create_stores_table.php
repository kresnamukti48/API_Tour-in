<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('user_id');
            $table->unsignedbigInteger('tour_id');
            $table->char('regency_id', 4);
            $table->char('province_id', 2);
            $table->string('store_name');
            $table->string('store_address');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('tour_id')->references('id')->on('tours');
            $table->foreign('regency_id')->references('id')->on('master_indonesia_cities');
            $table->foreign('province_id')->references('id')->on('master_indonesia_provinces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
};
