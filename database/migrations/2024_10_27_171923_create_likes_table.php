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
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Khóa ngoại tới bảng users
            $table->foreignId('comment_id')->nullable()->constrained('comments')->onDelete('cascade'); // Khóa ngoại tới bảng comments
            $table->foreignId('reply_id')->nullable()->constrained('replies')->onDelete('cascade'); // Khóa ngoại tới bảng replies
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
