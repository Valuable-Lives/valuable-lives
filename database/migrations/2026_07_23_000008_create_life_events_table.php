<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('life_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('individual_id')->constrained()->cascadeOnDelete();
            $table->foreignId('holding_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('event_type', [
                'birth', 'death', 'purchase', 'sale', 'manumission',
                'runaway', 'transported', 'executed', 'workhouse',
                'hired_out', 'moved_within_parish', 'moved_between_parishes',
                'baptism', 'marriage', 'burial', 'other',
            ]);
            $table->enum('register_year', ['1817', '1820', '1823', '1826', '1829', '1832'])->nullable();
            $table->date('event_date')->nullable();
            $table->text('cause_notes')->nullable();
            $table->foreignId('origin_destination_holding_id')->nullable()->constrained('holdings')->nullOnDelete();
            $table->timestamps();

            $table->index('individual_id');
            $table->index('event_type');
            $table->index('register_year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('life_events');
    }
};
