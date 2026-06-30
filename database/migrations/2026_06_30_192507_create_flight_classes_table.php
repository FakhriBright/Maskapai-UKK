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
        Schema::create('flight_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flight_id')->constrained()->onDelete('cascade');
            $table->string('class_name'); // 'economy', 'business', 'first'
            $table->decimal('price_multiplier', 5, 2)->default(1.00);
            $table->integer('baggage_allowance')->default(20); // in kg
            $table->string('seat_prefix')->nullable();
            $table->integer('seat_rows')->default(0);
            $table->integer('seat_columns')->default(0);
            $table->boolean('lounge_access')->default(false);
            $table->string('meal_type')->default('No Meal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_classes');
    }
};
