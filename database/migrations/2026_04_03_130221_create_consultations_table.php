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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('package_type')->default('single'); // single, progress(3), transform(5)
            $table->integer('sessions_count')->default(1);
            $table->decimal('amount', 8, 2);
            $table->text('symptoms');
            $table->text('medical_history')->nullable();
            $table->string('status')->default('pending'); // pending, in_progress, completed, cancelled
            $table->string('payment_intent')->nullable();
            $table->string('payment_status')->default('unpaid');
            $table->text('protocol_notes')->nullable();
            $table->string('protocol_url')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
