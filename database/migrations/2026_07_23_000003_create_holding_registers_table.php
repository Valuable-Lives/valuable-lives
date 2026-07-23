<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('holding_registers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('holding_id')->constrained()->cascadeOnDelete();
            $table->enum('register_year', ['1817', '1820', '1823', '1826', '1829', '1832']);
            $table->unsignedInteger('enslaved_total')->nullable();
            $table->unsignedInteger('enslaved_male')->nullable();
            $table->unsignedInteger('enslaved_female')->nullable();
            $table->unsignedInteger('enslaved_african')->nullable();
            $table->unsignedInteger('enslaved_creole')->nullable();
            $table->string('tna_reference')->nullable();
            $table->unsignedInteger('tna_page')->nullable();
            $table->timestamps();

            $table->unique(['holding_id', 'register_year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('holding_registers');
    }
};
