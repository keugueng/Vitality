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
        Schema::create('patient_protocols', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->string('status')->default('assigned'); // assigned, in_progress, completed
            $table->integer('sessions_done')->default(0);
            $table->integer('progress_percent')->default(0);
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_protocols');
    }
};
