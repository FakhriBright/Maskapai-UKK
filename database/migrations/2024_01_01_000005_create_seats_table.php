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
    Schema::create('seats', function (Blueprint $table) {
        $table->id();
        $table->foreignId('airplane_id')->constrained()->onDelete('cascade');
        $table->string('seat_number'); // Contoh: "12A"
        $table->enum('class', ['economy', 'business', 'first'])->default('economy');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
