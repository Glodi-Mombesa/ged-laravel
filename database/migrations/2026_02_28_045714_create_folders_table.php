<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique(); // utile pour URL/tri
            $table->text('description')->nullable();

            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('folders')->nullOnDelete();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['service_id', 'parent_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('folders');
    }
};