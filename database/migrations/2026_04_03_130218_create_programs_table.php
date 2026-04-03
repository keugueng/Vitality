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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('title_fr');
            $table->string('slug', 191)->unique();
            $table->string('emoji')->nullable();
            $table->text('short_desc');
            $table->text('short_desc_fr');
            $table->longText('long_desc')->nullable();
            $table->longText('long_desc_fr')->nullable();
            $table->string('session_duration')->default('25 min');
            $table->string('cure_duration')->default('21-30 jours');
            $table->decimal('price', 8, 2)->default(29.90);
            $table->boolean('is_bestseller')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->json('benefits')->nullable();
            $table->json('tags')->nullable();
            $table->string('image')->nullable();
            $table->string('audio_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
