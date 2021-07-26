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
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('souvenirs', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('souvenir_stocks', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('tours', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('virtualtours', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('virtualtourgalleries', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('stores', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('tickets', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('souvenirs', function (Blueprint $table) {
            $table->dropSoftdeletes();
        });
        Schema::table('souvenir_stocks', function (Blueprint $table) {
            $table->dropSoftdeletes();
        });
        Schema::table('tours', function (Blueprint $table) {
            $table->dropSoftdeletes();
        });
        Schema::table('virtualtours', function (Blueprint $table) {
            $table->dropSoftdeletes();
        });
        Schema::table('virtualtourgalleries', function (Blueprint $table) {
            $table->dropSoftdeletes();
        });
        Schema::table('stores', function (Blueprint $table) {
            $table->dropSoftdeletes();
        });
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropSoftdeletes();
        });
    }
};
