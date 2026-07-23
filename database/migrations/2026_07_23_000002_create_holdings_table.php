<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('holdings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('parish_id')->nullable()->constrained()->nullOnDelete();
            $table->string('town_address')->nullable();
            $table->enum('type', ['plantation', 'pen', 'jobbing_gang', 'urban_household', 'other'])->nullable();
            $table->enum('size_category', ['under_10', '10_49', '50_99', '100_plus'])->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->unsignedBigInteger('lbs_estate_id')->nullable();
            $table->enum('quality_flag', ['okay', 'probs', 'bigprobs', 'gone'])->default('okay');
            $table->timestamps();

            $table->index('parish_id');
            $table->index('lbs_estate_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('holdings');
    }
};
