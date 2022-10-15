<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('shipping_name', 255);
            $table->string('shipping_phone', 11);
            $table->text('shipping_address');
            $table->text('note')->nullable();
            $table->tinyInteger('payment_method');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shippings');
    }
};
