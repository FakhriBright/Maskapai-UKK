<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Identitas
            $table->string('nik', 16)->nullable()->after('email');
            $table->string('phone', 20)->nullable()->after('nik');
            $table->enum('gender', ['male', 'female'])->nullable()->after('phone');
            $table->date('birth_date')->nullable()->after('gender');
            
            // Alamat
            $table->text('address')->nullable()->after('birth_date');
            $table->string('city', 100)->nullable()->after('address');
            $table->string('province', 100)->nullable()->after('city');
            $table->string('postal_code', 10)->nullable()->after('province');
            
            // Identitas Resmi
            $table->enum('identity_type', ['ktp', 'passport'])->nullable()->after('postal_code');
            $table->string('identity_number', 50)->nullable()->after('identity_type');
            
            // Lainnya
            $table->string('nationality', 50)->default('Indonesia')->after('identity_number');
            $table->string('photo')->nullable()->after('nationality');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nik',
                'phone',
                'gender',
                'birth_date',
                'address',
                'city',
                'province',
                'postal_code',
                'identity_type',
                'identity_number',
                'nationality',
                'photo',
            ]);
        });
    }
};