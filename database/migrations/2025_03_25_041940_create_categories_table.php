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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string(column:'name');
            $table->string(column: 'slug')->unique();
            $table->foreignId(column: 'parent_id')
            ->nullable()
            ->constrained(table: 'categories')
            ->cascadeOnDelete();
            $table->boolean(column: 'is_visible')->default(value: false);
            $table->longText(column: 'description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
