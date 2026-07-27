<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('increase_decreases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enslaved_record_id')->constrained()->cascadeOnDelete();
            $table->enum('increase_or_decrease', ['increase', 'decrease']);
            $table->text('full_text')->nullable();
            $table->string('type')->nullable();
            $table->unsignedTinyInteger('day')->nullable();
            $table->unsignedTinyInteger('month')->nullable();
            $table->unsignedSmallInteger('year')->nullable();
            $table->foreignId('inc_dec_parish_id')->nullable()->constrained('parishes')->nullOnDelete();
            $table->string('inc_dec_estate_name')->nullable();
            $table->string('inc_dec_town')->nullable();
            $table->text('record_notes')->nullable();
            $table->text('public_notes')->nullable();
            $table->timestamps();

            $table->index('enslaved_record_id');
            $table->index('type');
        });

        Schema::create('inc_dec_enslavers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('increase_decrease_id')->constrained()->cascadeOnDelete();
            $table->text('enslaver_full_name')->nullable();
            $table->string('enslaver_name_prefix')->nullable();
            $table->string('enslaver_given_name')->nullable();
            $table->string('enslaver_surname')->nullable();
            $table->string('enslaver_given_name_alias')->nullable();
            $table->string('enslaver_surname_alias')->nullable();
            $table->string('enslaver_name_suffix')->nullable();
            $table->text('record_notes')->nullable();
            $table->text('public_notes')->nullable();
            $table->timestamps();

            $table->index('increase_decrease_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inc_dec_enslavers');
        Schema::dropIfExists('increase_decreases');
    }
};
