<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->foreignId('shipping_id')->constrained('shippings')->onUpdate('cascade')->onDelete('cascade');
            $table->string('order_code', 8)->unique();
            $table->tinyInteger('status')->default(1);
            $table->integer('fee_ship');
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
