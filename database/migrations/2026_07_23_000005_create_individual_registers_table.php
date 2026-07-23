<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('individual_registers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('individual_id')->constrained()->cascadeOnDelete();
            $table->enum('register_year', ['1817', '1820', '1823', '1826', '1829', '1832']);
            $table->unsignedSmallInteger('age')->nullable();
            $table->foreignId('holding_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->unique(['individual_id', 'register_year']);
            $table->index('holding_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('individual_registers');
    }
};
