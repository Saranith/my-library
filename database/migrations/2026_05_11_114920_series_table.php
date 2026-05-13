<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('author')->nullable();
            $table->text('synopsis')->nullable();
            $table->text('cover_image')->nullable();
            $table->string('source_link', 500)->nullable();
            
            // Fixed: Removed the apostrophe from 'Collectors Edition' to prevent SQLite syntax errors
            $table->enum('format_origin', ['Digital Scan', 'Tankobon Physical', 'Serialization', 'Collectors Edition'])->default('Digital Scan');
            
            $table->date('induction_date');
            $table->unsignedInteger('chapters_completed')->default(0);
            $table->unsignedInteger('chapters_total')->nullable();
            $table->decimal('rating', 3, 1)->nullable();
            $table->enum('status', ['Plan to Read', 'Currently Reading', 'Completed', 'On Hold', 'Dropped'])->default('Plan to Read');
            $table->enum('type', ['MANGA', 'MANHUA', 'MANHWA'])->default('MANGA');
            $table->json('tags')->nullable();
            $table->json('official_sources')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'type']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
