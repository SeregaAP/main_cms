<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tv_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');              // Название TV
            $table->string('key')->unique();     // Уникальный ключ (price, gallery)
            $table->enum('type', ['text', 'image', 'migx']);
            $table->text('description')->nullable();
            $table->json('config')->nullable();  // Настройки (migx schema, image options)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tv_forms');
    }
};
