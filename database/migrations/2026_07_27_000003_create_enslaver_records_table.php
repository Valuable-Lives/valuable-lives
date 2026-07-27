<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enslaver_records', function (Blueprint $table) {
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
            $table->text('enslaver_name_full')->nullable();
            $table->string('enslaver_name_prefix')->nullable();
            $table->string('enslaver_given_name')->nullable();
            $table->string('enslaver_surname')->nullable();
            $table->string('enslaver_name_suffix')->nullable();
            $table->string('enslaver_given_name_alias')->nullable();
            $table->string('enslaver_surname_alias')->nullable();
            $table->string('enslaver_gender')->nullable();
            $table->string('enslaver_race')->nullable();
            $table->string('enslaver_capacity')->nullable();
            $table->string('enslaver_capacity_note')->nullable();
            $table->boolean('enslaver_signed')->nullable();
            $table->text('record_notes')->nullable();
            $table->text('public_notes')->nullable();
            $table->timestamps();

            $table->index('unique_identifier');
            $table->index('entry_id');
            $table->index('enslaver_surname');
            $table->index('register_year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enslaver_records');
    }
};
