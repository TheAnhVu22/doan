<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username', 50)->unique();
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->text('avatar')->nullable();
            $table->string('phone', 11);
            $table->date('birthday');
            $table->tinyInteger('is_active')->default(1);
            $table->foreignId('role_id')->constrained('roles')->onUpdate('cascade')->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admins');
    }
};
