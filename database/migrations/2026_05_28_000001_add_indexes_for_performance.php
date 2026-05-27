<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Index untuk query attendance yang sering dipakai
        Schema::table('attendances', function (Blueprint $table) {
            $table->index(['user_id', 'date'], 'idx_attendance_user_date');
            $table->index('date', 'idx_attendance_date');
        });

        // Index untuk query schedule
        Schema::table('schedules', function (Blueprint $table) {
            $table->index(['user_id', 'date'], 'idx_schedule_user_date');
            $table->index('date', 'idx_schedule_date');
        });

        // Index untuk query user
        Schema::table('users', function (Blueprint $table) {
            $table->index(['role', 'is_active'], 'idx_users_role_active');
            $table->index(['department_id', 'is_active'], 'idx_users_dept_active');
            $table->index('phone', 'idx_users_phone');
            $table->index('wa_lid', 'idx_users_wa_lid');
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex('idx_attendance_user_date');
            $table->dropIndex('idx_attendance_date');
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropIndex('idx_schedule_user_date');
            $table->dropIndex('idx_schedule_date');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_role_active');
            $table->dropIndex('idx_users_dept_active');
            $table->dropIndex('idx_users_phone');
            $table->dropIndex('idx_users_wa_lid');
        });
    }
};
