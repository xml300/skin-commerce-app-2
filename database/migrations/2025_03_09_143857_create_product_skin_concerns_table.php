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
        Schema::create('productskinconcerns', function (Blueprint $table) {
            $table->integer('product_id');
            $table->integer('skin_concern_id');

            $table->primary(['product_id', 'skin_concern_id']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('skin_concern_id')->references('id')->on('skinconcerns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productskinconcerns');
    }
};
