<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah kolom user_type dari ENUM ke VARCHAR agar bisa menerima
        // code dinamis dari tabel user_types (tidak terbatas pada nilai ENUM)
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type VARCHAR(100) NULL");
    }

    public function down(): void
    {
        // Rollback ke ENUM (data yang tidak cocok akan hilang)
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('magang', 'daily_worker', 'admin') NULL");
    }
};
