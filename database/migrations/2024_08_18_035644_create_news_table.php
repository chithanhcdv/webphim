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
        Schema::create('news', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug');
        $table->text('content');
        $table->text('title_image')->nullable();
        $table->text('content_image')->nullable();
        $table->text('other_content')->nullable();
        $table->text('other_image')->nullable();
        $table->timestamps();       
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};