<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->foreignId('comment_parent_id')->nullable()->after('id')->constrained('comments')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('comment_parent_id');
        });
    }
};
