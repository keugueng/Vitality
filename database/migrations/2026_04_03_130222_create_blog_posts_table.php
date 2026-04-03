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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('title');
            $table->string('title_fr');
            $table->string('slug', 191)->unique();
            $table->text('excerpt')->nullable();
            $table->text('excerpt_fr')->nullable();
            $table->longText('content');
            $table->longText('content_fr')->nullable();
            $table->string('image')->nullable();
            $table->string('category')->nullable();
            $table->json('tags')->nullable();
            $table->integer('read_time')->default(5);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
