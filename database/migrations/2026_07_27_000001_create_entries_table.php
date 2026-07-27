<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unique_identifier')->nullable();
            $table->unsignedInteger('original_order')->nullable();
            $table->string('source_piece_number')->nullable();
            $table->string('image_file_name')->nullable();
            $table->string('image_folder')->nullable();
            $table->string('tna_ref')->nullable();
            $table->unsignedInteger('registers_page_number')->nullable();
            $table->enum('register_year', ['1817', '1820', '1823', '1826', '1829', '1832']);
            $table->foreignId('parish_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('previous_total_males')->nullable();
            $table->unsignedInteger('previous_total_females')->nullable();
            $table->unsignedInteger('total_last_return')->nullable();
            $table->unsignedInteger('this_return_total_males')->nullable();
            $table->unsignedInteger('this_return_total_females')->nullable();
            $table->unsignedInteger('total_this_return')->nullable();
            $table->unsignedInteger('number_increase')->nullable();
            $table->unsignedInteger('number_decrease')->nullable();
            $table->text('entry_text')->nullable();
            $table->string('estate_name')->nullable();
            $table->text('record_notes')->nullable();
            $table->text('public_notes')->nullable();
            $table->timestamps();

            $table->index('unique_identifier');
            $table->index('register_year');
            $table->index('parish_id');
            $table->index('tna_ref');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
