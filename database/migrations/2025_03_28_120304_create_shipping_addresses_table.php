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
        Schema::create('shipping_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('street_address1');
            $table->string('street_address2')->nullable();
            $table->string('city', 100);
            $table->string('state_region', 100); 
            $table->string('country', 100);
            
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
 $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            
            $table->unique([
                'user_id',
                'street_address1',
                'street_address2',
                'city',
                'state_region', 
                'country'
            ], 'user_full_address_unique'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_addresses');
    }
};