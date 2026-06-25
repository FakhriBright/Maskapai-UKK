<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('passengers', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->after('booking_id')
                ->constrained()
                ->cascadeOnDelete();
        });

        DB::table('passengers')
            ->join('bookings', 'passengers.booking_id', '=', 'bookings.id')
            ->whereNull('passengers.user_id')
            ->update(['passengers.user_id' => DB::raw('bookings.user_id')]);
    }

    public function down(): void
    {
        Schema::table('passengers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
