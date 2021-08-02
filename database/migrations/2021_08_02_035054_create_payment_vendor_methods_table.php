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
        Schema::create('payment_vendor_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_vendor_id')->constrained('payment_vendors');
            $table->foreignId('payment_category_id')->nullable()->constrained('payment_categories');
            $table->string('name');
            $table->string('code');
            $table->integer('type')->default(1)->comment('1. Fixed; 2. Percentage');
            $table->float('markup')->default(0);
            $table->integer('type_fee')->default(1)->comment('1. Fixed; 2. Percentage');
            $table->float('fee_pg')->default(0);
            $table->integer('type_disc')->default(1)->comment('1. Fixed; 2. Percentage');
            $table->float('disc_pg')->default(0);
            $table->float('minimal_amount')->default(0);
            $table->boolean('status')->default(false);
            $table->timestamps();
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
        Schema::dropIfExists('payment_vendor_methods');
    }
};
