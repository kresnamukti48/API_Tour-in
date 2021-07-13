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
        Schema::table('tours', function (Blueprint $table) {
            $table->char('regency_id', 4)->after('tour_name');
            $table->char('province_id', 2)->after('regency_id');
            $table->unsignedbigInteger('user_id')->after('province_id');

            $table->foreign('regency_id')->references('id')->on('master_indonesia_cities');
            $table->foreign('province_id')->references('id')->on('master_indonesia_provinces');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropForeign([
                'regency_id',
                'province_id',
                'user_id',
            ]);

            $table->dropColumn([
                'regency_id',
                'province_id',
                'user_id',
            ]);
        });
    }
};
