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
        Schema::create('order_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('ticket_id')->constrained('tickets');
            $table->integer('trx_id')->unique();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->integer('ticket_price');
            $table->integer('mark_up_fee');
            $table->integer('payment_fee');
            $table->integer('discount_item');
            $table->integer('discount_payment');
            $table->integer('total');
            $table->string('payment_ref');
            $table->string('merchant_ref');
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
        Schema::dropIfExists('order_tickets');
    }
};
