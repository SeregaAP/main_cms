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
        Schema::create('document_tvs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('documents')->onDelete('cascade');
            $table->foreignId('form_tv_id')->constrained('forms_tv')->onDelete('cascade');
            $table->json('value')->nullable(); // храним значение(я) в JSON
            $table->string('name'); 
            $table->timestamps();

            // один TV для одного документа — либо можно позволить много — решай сам
            //$table->unique(['document_id','form_tv_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_tvs');
    }
};
