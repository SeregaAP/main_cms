<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // заголовок
            $table->string('alias')->unique(); // уникальный alias/slug
            $table->text('content')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('documents')->onDelete('cascade');
            $table->boolean('published')->default(true);
            $table->string('type')->default('html');
            $table->string('uri')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
