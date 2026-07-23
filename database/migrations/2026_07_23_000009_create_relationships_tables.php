<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('relationship_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('inverse_name')->nullable();
        });

        Schema::create('relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person1_id')->constrained('individuals')->cascadeOnDelete();
            $table->foreignId('person2_id')->constrained('individuals')->cascadeOnDelete();
            $table->foreignId('relationship_type_id')->constrained()->restrictOnDelete();
            $table->enum('source', ['registers', 'inferred', 'other_documents'])->default('registers');
            $table->enum('confidence', ['confirmed', 'probable', 'possible'])->default('confirmed');
            $table->timestamps();

            $table->index('person1_id');
            $table->index('person2_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('relationships');
        Schema::dropIfExists('relationship_types');
    }
};
