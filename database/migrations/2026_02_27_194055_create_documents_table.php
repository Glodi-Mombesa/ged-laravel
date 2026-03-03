<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('reference')->nullable();   // ex: REF-2026-001
            $table->text('description')->nullable();

            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();

            $table->string('file_path');               // storage path
            $table->string('original_name');
            $table->unsignedBigInteger('file_size')->default(0);
            $table->string('mime_type')->nullable();

            $table->enum('status', ['draft','validated','archived'])->default('draft');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};