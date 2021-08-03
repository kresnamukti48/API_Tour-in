<?php

use App\Models\OrderTicket;
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
        Schema::table('order_tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('payment_id')->after('ticket_price');
            $table->integer('status')->after('merchant_ref')->default(OrderTicket::STATUS_WAITING);
            $table->integer('ticket_price')->default(0)->change();
            $table->integer('mark_up_fee')->default(0)->change();
            $table->integer('payment_fee')->default(0)->change();
            $table->integer('discount_item')->default(0)->change();
            $table->integer('discount_payment')->default(0)->change();
            $table->integer('total')->default(0)->change();
            $table->string('payment_ref')->nullable()->change();
            $table->string('merchant_ref')->nullable()->change();
            $table->foreign('payment_id')->references('id')->on('payment_channels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_tickets', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
            $table->string('payment_ref')->nullable(false)->change();
            $table->string('merchant_ref')->nullable(false)->change();
            $table->dropColumn(['payment_id', 'status']);
        });
    }
};
