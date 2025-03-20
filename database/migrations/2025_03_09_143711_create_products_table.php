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
        Schema::create('products', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('product_name');
            $table->text('description');
            $table->integer('brand_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock_quantity')->default(0);
            $table->decimal('rating_average', 2, 1)->nullable();
            $table->integer('review_count')->default(0);
            $table->timestamps();

            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
