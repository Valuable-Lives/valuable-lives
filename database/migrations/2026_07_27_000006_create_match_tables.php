<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Shared match audit columns as a closure
        $matchColumns = function (Blueprint $table) {
            $table->decimal('match_rating', 8, 2)->nullable();
            $table->decimal('gap_rating', 8, 2)->nullable();
            $table->string('match_type')->nullable();
            $table->text('match_notes')->nullable();
            $table->text('public_match_notes')->nullable();
            $table->string('match_user')->nullable();
            $table->date('match_date')->nullable();
            $table->timestamps();
        };

        Schema::create('enslaved_matches', function (Blueprint $table) use ($matchColumns) {
            $table->id();
            $table->foreignId('enslaved_record_id')->constrained()->cascadeOnDelete();
            $table->foreignId('individual_id')->constrained()->cascadeOnDelete();
            $matchColumns($table);

            $table->index('enslaved_record_id');
            $table->index('individual_id');
        });

        Schema::create('enslaver_matches', function (Blueprint $table) use ($matchColumns) {
            $table->id();
            $table->foreignId('enslaver_record_id')->constrained()->cascadeOnDelete();
            $table->foreignId('individual_id')->constrained()->cascadeOnDelete();
            $matchColumns($table);

            $table->index('enslaver_record_id');
            $table->index('individual_id');
        });

        Schema::create('holding_matches', function (Blueprint $table) use ($matchColumns) {
            $table->id();
            $table->foreignId('entry_id')->constrained()->cascadeOnDelete();
            $table->foreignId('holding_id')->constrained()->cascadeOnDelete();
            $matchColumns($table);

            $table->index('entry_id');
            $table->index('holding_id');
        });

        Schema::create('holding_estate_links', function (Blueprint $table) use ($matchColumns) {
            $table->id();
            $table->foreignId('holding_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('estate_id');
            $matchColumns($table);

            $table->index('holding_id');
            $table->index('estate_id');
        });

        Schema::create('entry_evolutions', function (Blueprint $table) use ($matchColumns) {
            $table->id();
            $table->foreignId('entry_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('evolution_id');
            $matchColumns($table);

            $table->index('entry_id');
            $table->index('evolution_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entry_evolutions');
        Schema::dropIfExists('holding_estate_links');
        Schema::dropIfExists('holding_matches');
        Schema::dropIfExists('enslaver_matches');
        Schema::dropIfExists('enslaved_matches');
    }
};
