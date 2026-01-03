<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_tv_values', function (Blueprint $table) {
            $table->id();

            $table->foreignId('document_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('tv_form_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->longText('value')->nullable(); // text | json | image path

            $table->timestamps();

            $table->unique(['document_id', 'tv_form_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_tv_values');
    }
};
