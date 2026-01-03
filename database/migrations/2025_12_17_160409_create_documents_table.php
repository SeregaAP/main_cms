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
            $table->string('title');
            $table->text('content')->nullable();
            $table->enum('type', ['document', 'category', 'product'])->default('document');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('alias')->unique()->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('documents')->nullOnDelete();
            $table->string('format')->default('html');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('published')->default(true);
            $table->boolean('show_in_menu')->default(false);
            $table->boolean('is_cache')->default(true);
            $table->integer('position')->default(0)->index();
            $table->index('type');
            $table->string('full_path')->nullable();
            $table->index('published');
            $table->index(['parent_id', 'published']);
            $table->foreignId('template_id')->nullable()->constrained('templates')->nullOnDelete();
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
