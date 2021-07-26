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
        Schema::create('souvenir_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('souvenir_id');
            $table->date('date');
            $table->integer('qty_in');
            $table->integer('qty_out');
            $table->string('note');
            $table->timestamps();

            $table->foreign('souvenir_id')->references('id')->on('souvenirs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('souvenir_stocks');
    }
};
