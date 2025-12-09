<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Для folders (self-reference)
        Schema::table('folders', function (Blueprint $table) {
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('folders')
                  ->onDelete('cascade');
        });

        // Для media_files
        Schema::table('media_files', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('folder_id')
                  ->references('id')
                  ->on('folders')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('media_files', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['folder_id']);
        });

        Schema::table('folders', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });
    }
};
