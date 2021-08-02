<?php

use App\Models\PaymentChannels;
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
        Schema::create('payment_channels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_method_vendor_id')->constrained('payment_vendor_methods');
            $table->string('payment_name');
            $table->string('payment_code');
            $table->text('payment_logo');
            $table->longText('payment_description');
            $table->integer('status')->default(PaymentChannels::STATUS_DISABLED);
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
        Schema::dropIfExists('payment_channels');
    }
};
