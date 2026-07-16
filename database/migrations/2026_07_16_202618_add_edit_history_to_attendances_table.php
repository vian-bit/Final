<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->time('original_check_in')->nullable()->after('check_out');
            $table->time('original_check_out')->nullable()->after('original_check_in');
            $table->foreignId('edited_by')->nullable()->constrained('users')->nullOnDelete()->after('original_check_out');
            $table->timestamp('edited_at')->nullable()->after('edited_by');
            $table->string('edit_reason')->nullable()->after('edited_at');
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropConstrainedForeignId('edited_by');
            $table->dropColumn(['original_check_in', 'original_check_out', 'edited_at', 'edit_reason']);
        });
    }
};
