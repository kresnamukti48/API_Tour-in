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
        Schema::create('virtualtours', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('user_id');
            $table->unsignedbigInteger('tour_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('tour_id')->references('id')->on('tours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('virtualtours', function (Blueprint $table) {
            $table->dropForeign([
                'user_id',
            ]);

            $table->dropColumn([
                'user_id',
            ]);
        });

        Schema::table('virtualtours', function (Blueprint $table) {
            $table->dropForeign([
                'tour_id',
            ]);

            $table->dropColumn([
                'tour_id',
            ]);
        });
    }
};
