<?php

use App\Models\OrderSouvenir;
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
        Schema::create('order_souvenirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('souvenir_id')->constrained('souvenirs');
            $table->integer('trx_id')->unique();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->integer('souvenir_price');
            $table->foreignId('payment_id')->constrained('payment_channels');
            $table->integer('mark_up_fee')->default(0);
            $table->integer('payment_fee')->default(0);
            $table->integer('discount_item')->default(0);
            $table->integer('discount_payment')->default(0);
            $table->integer('total')->default(0);
            $table->string('payment_ref')->nullable();
            $table->string('merchant_ref')->nullable();
            $table->integer('status')->default(OrderSouvenir::STATUS_WAITING);
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
        Schema::dropIfExists('order_souvenirs');
    }
};
