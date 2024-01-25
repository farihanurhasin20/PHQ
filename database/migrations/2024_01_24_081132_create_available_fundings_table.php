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
        Schema::create('available_fundings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funding_source_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->double('total_amount',10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('available_fundings');
    }
};
