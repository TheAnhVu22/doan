<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('category_id')->constrained('category_products')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('brand_id')->constrained('brand_products')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name', 200)->unique();
            $table->string('slug', 255)->unique();
            $table->text('description')->nullable();
            $table->integer('price');
            $table->text('tags')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('views')->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
