<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('city_name', 100);
            $table->string('type', 30);
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->string('district_name', 100);
            $table->string('type', 30);
            $table->foreignId('city_id')->constrained('cities')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('wards', function (Blueprint $table) {
            $table->id();
            $table->string('ward_name', 100);
            $table->string('type', 30);
            $table->foreignId('district_id')->constrained('districts')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('wards');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('cities');
    }
};
