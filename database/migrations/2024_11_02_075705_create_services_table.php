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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên dịch vụ (ví dụ: Dịch vụ tháng, Dịch vụ năm)
            $table->text('description')->nullable(); // Mô tả dịch vụ
            $table->decimal('price', 8, 2); // Giá dịch vụ
            $table->integer('duration'); // Thời hạn dịch vụ (số ngày, tháng hoặc năm)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
