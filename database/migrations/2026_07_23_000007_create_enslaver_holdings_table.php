<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enslaver_holdings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enslaver_id')->constrained()->cascadeOnDelete();
            $table->foreignId('holding_id')->constrained()->cascadeOnDelete();
            $table->string('capacity')->nullable();
            $table->enum('register_year', ['1817', '1820', '1823', '1826', '1829', '1832'])->nullable();
            $table->timestamps();

            $table->index(['enslaver_id', 'holding_id']);
            $table->index('holding_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enslaver_holdings');
    }
};
