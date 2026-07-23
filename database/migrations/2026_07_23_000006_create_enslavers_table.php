<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enslavers', function (Blueprint $table) {
            $table->id();
            $table->string('prefix')->nullable();
            $table->string('given_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('suffix')->nullable();
            $table->enum('sex', ['male', 'female', 'unknown'])->nullable();
            $table->string('colour')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('lbs_individual_id')->nullable();
            $table->timestamps();

            $table->index('surname');
            $table->index('lbs_individual_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enslavers');
    }
};
