<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enslaved_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unique_identifier')->nullable();
            $table->unsignedInteger('original_order')->nullable();
            $table->string('source_piece_number')->nullable();
            $table->string('image_file_name')->nullable();
            $table->string('image_folder')->nullable();
            $table->string('tna_ref')->nullable();
            $table->unsignedInteger('registers_page_number')->nullable();
            $table->enum('register_year', ['1817', '1820', '1823', '1826', '1829', '1832'])->nullable();
            $table->foreignId('parish_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('entry_id')->nullable()->constrained()->cascadeOnDelete();
            $table->text('enslaved_name_full')->nullable();
            $table->string('enslaved_name_prefix')->nullable();
            $table->unsignedInteger('enslaved_name_number')->nullable();
            $table->string('enslaved_given_name')->nullable();
            $table->string('enslaved_surname')->nullable();
            $table->string('enslaved_given_name_alias')->nullable();
            $table->string('enslaved_surname_alias')->nullable();
            $table->string('enslaved_name_suffix')->nullable();
            $table->string('birthplace')->nullable();
            $table->string('gender')->nullable();
            $table->string('colour')->nullable();
            $table->string('height')->nullable();
            $table->text('physical_description')->nullable();
            $table->string('occupation')->nullable();
            $table->unsignedSmallInteger('age_years')->nullable();
            $table->unsignedSmallInteger('age_months')->nullable();
            $table->unsignedSmallInteger('age_days')->nullable();
            $table->text('remarks')->nullable();
            $table->text('record_notes')->nullable();
            $table->text('public_notes')->nullable();
            $table->timestamps();

            $table->index('unique_identifier');
            $table->index('entry_id');
            $table->index('enslaved_given_name');
            $table->index('enslaved_surname');
            $table->index('register_year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enslaved_records');
    }
};
