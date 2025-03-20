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
            $table->integer('id')->primary();
            $table->integer('user_id');
            $table->timestamp('order_date')->nullable();
            $table->string('order_status');
            $table->string('shipping_address')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('payment_method');
            $table->decimal('tax_amount', 10, 2)->nullable();
            $table->string('shipping_method');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('shipping_cost', 10, 2)->nullable();
            $table->decimal('discount_applied', 10, 2)->nullable();
            $table->string('tracking_number')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
