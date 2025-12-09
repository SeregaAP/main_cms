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
        Schema::create('forms_tv', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('templates')->onDelete('cascade');
            $table->string('name');        // системное имя TV, например "gallery"
            $table->string('caption')->nullable(); // человекочитаемое имя (опционально)
            $table->json('form');         // json схема (обязательное поле, у тебя так)
            $table->timestamps();

            $table->unique(['template_id','name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms_tv');
    }
};
