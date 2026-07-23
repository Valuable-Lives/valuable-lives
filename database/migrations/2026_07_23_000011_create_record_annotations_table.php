<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('record_annotations', function (Blueprint $table) {
            $table->id();
            $table->morphs('annotatable');
            $table->string('title')->nullable();
            $table->text('content_html');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('record_annotations');
    }
};
