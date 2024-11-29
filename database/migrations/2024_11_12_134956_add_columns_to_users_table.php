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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('set null');
            $table->timestamp('service_start_at')->nullable();
            $table->timestamp('service_end_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Xóa các cột nếu cần rollback migration
            $table->dropForeign(['service_id']);
            $table->dropColumn(['service_id', 'service_start_at', 'service_end_at']);
        });
    }
};
