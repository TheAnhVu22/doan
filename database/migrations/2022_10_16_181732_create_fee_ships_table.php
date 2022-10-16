<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fee_ships', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('city_id')->constrained('cities')->onUpdate('cascade')->onDelete('cascade');      
            $table->foreignId('district_id')->constrained('districts')->onUpdate('cascade')->onDelete('cascade');      
            $table->foreignId('ward_id')->constrained('wards')->onUpdate('cascade')->onDelete('cascade');      
            $table->integer('fee_ship');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fee_ships');
    }
};
