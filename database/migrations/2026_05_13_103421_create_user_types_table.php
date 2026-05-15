<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Seed default types from existing enum values
        DB::table('user_types')->insert([
            ['name' => 'Intern', 'code' => 'magang', 'description' => 'Karyawan magang', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Daily Worker', 'code' => 'daily_worker', 'description' => 'Karyawan harian', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Admin', 'code' => 'admin', 'description' => 'Admin departemen', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('user_types');
    }
};
