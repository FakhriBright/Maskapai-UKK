<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void {
    Schema::create('flights', function (Blueprint $table) {
        $table->id();
        $table->foreignId('airline_id')->constrained()->onDelete('cascade');
        $table->foreignId('airplane_id')->constrained()->onDelete('cascade');
        $table->foreignId('departure_airport_id')->constrained('airports')->onDelete('cascade');
        $table->foreignId('arrival_airport_id')->constrained('airports')->onDelete('cascade');
        $table->string('flight_number');
        $table->dateTime('departure_time');
        $table->dateTime('arrival_time');
        $table->decimal('price', 12, 2);
        $table->integer('available_seats'); // Akan diupdate saat booking confirmed
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
