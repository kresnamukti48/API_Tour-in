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
        Schema::create('virtualtourgalleries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->before('gallery');
            $table->string('gallery');
            $table->unsignedbigInteger('virtualtour_id');
            $table->timestamps();

            $table->foreign('virtualtour_id')->references('id')->on('virtualtours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('virtualtourgalleries', function (Blueprint $table) {
            $table->dropForeign([
                'virtualtour_id',
            ]);

            $table->dropColumn([
                'virtualtour_id',
            ]);
        });
    }
};
