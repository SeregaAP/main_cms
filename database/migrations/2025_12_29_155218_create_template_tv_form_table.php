<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('template_tv_form', function (Blueprint $table) {
            $table->id();

            $table->foreignId('template_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('tv_form_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('position')->default(0);

            $table->unique(['template_id', 'tv_form_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_tv_form');
    }
};
