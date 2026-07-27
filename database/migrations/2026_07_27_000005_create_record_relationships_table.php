<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('record_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enslaved_record_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('enslaver_record_id')->nullable()->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('relation_record_id')->nullable();
            $table->text('relationship_full_text')->nullable();
            $table->string('relation_to')->nullable();
            $table->string('relation_from')->nullable();
            $table->text('relation_full_name')->nullable();
            $table->string('relation_name_prefix')->nullable();
            $table->string('relation_surname')->nullable();
            $table->string('relation_given_name')->nullable();
            $table->string('relation_given_name_alias')->nullable();
            $table->string('relation_surname_alias')->nullable();
            $table->string('relation_name_suffix')->nullable();
            $table->text('record_notes')->nullable();
            $table->text('public_notes')->nullable();
            $table->timestamps();

            $table->index('enslaved_record_id');
            $table->index('enslaver_record_id');
            $table->index('relation_record_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('record_relationships');
    }
};
