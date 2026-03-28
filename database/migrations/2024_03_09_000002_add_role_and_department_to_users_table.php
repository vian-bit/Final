<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['superuser', 'admin', 'user'])->default('user')->after('email');
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null')->after('role');
            $table->enum('user_type', ['magang', 'daily_worker'])->nullable()->after('department_id');
            $table->date('start_date')->nullable()->after('user_type');
            $table->boolean('is_active')->default(true)->after('start_date');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropColumn(['role', 'department_id', 'user_type', 'start_date', 'is_active']);
        });
    }
};
