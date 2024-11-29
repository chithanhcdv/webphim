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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->foreignId('release_year_id')->nullable()->constrained('release_years')->onDelete('set null');
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->string('director')->nullable();
            $table->string('studio')->nullable();
            $table->string('actor')->nullable();
            $table->integer('total_episode')->nullable();
            $table->string('other_name')->nullable();
            $table->text('image')->nullable();
            $table->text('background_image')->nullable();
            $table->boolean('hot')->default(0);
            $table->timestamps();
        });       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }   
};