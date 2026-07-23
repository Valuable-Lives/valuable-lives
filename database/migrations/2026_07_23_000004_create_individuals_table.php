<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('individuals', function (Blueprint $table) {
            $table->id();
            $table->string('given_name')->nullable();
            $table->string('surname')->nullable();
            $table->enum('sex', ['male', 'female'])->nullable();
            $table->string('colour')->nullable();
            $table->enum('birthplace', ['african', 'creole'])->nullable();
            $table->string('country_nation')->nullable();
            $table->unsignedSmallInteger('estimated_birth_year')->nullable();
            $table->unsignedSmallInteger('death_year')->nullable();
            $table->text('appearance')->nullable();
            $table->timestamps();

            $table->index(['given_name', 'surname']);
            $table->index('birthplace');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('individuals');
    }
};
