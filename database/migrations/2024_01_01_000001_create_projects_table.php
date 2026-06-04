<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_ar')->nullable();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('overview')->nullable();
            $table->text('overview_ar')->nullable();
            $table->text('features')->nullable();
            $table->text('features_ar')->nullable();
            $table->text('challenges')->nullable();
            $table->text('challenges_ar')->nullable();
            $table->string('cover_image')->nullable();
            $table->json('technologies')->nullable();
            $table->string('github_link')->nullable();
            $table->string('demo_link')->nullable();
            $table->string('category')->default('web');
            $table->boolean('featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
