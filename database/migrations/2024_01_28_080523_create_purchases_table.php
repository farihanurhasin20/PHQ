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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('founding_source_id');
            $table->foreignId('item_id');
            $table->foreignId('item_unit_id');
            $table->date('date');
            $table->decimal('unit_price', 10, 2);
            $table->unsignedInteger('qty'); 
            $table->decimal('grand_total', 10, 2);
            $table->string('purchase_number')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
