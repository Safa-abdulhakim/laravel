<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('analyses', function (Blueprint $table) {
            $table->id();
            $table->longText('text');
            $table->string('primary_indicator');
            $table->decimal('confidence_score', 5, 2)->default(0);
            $table->json('probabilities');
            $table->json('detected_keywords')->nullable();
            $table->json('highlighted_segments')->nullable();
            $table->integer('word_count')->default(0);
            $table->float('processing_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyses');
    }
};
