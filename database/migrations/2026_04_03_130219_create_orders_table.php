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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('order_number', 191)->unique();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('status')->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('payment_intent')->nullable();
            $table->string('promo_code')->nullable();
            $table->decimal('discount', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
