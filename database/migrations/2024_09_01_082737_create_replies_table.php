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
        Schema::create('replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comment_id')->constrained('comments')->onDelete('cascade'); // Khóa ngoại tới bảng comments
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Khóa ngoại tới bảng users
            $table->text('content'); // Nội dung phản hồi
            $table->text('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('replies');
    }
};
