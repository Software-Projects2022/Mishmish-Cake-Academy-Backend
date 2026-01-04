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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_category_id')->nullable()->constrained('course_categories')->nullOnDelete();
            $table->foreignId('instructor_id')->nullable()->constrained('instructors')->nullOnDelete();
            $table->string('title')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('short_description')->nullable();
            $table->string('short_description_ar')->nullable();
            $table->string('description')->nullable();
            $table->string('description_ar')->nullable();
            $table->string('course_duration')->nullable();
            $table->string('course_duration_ar')->nullable();
            $table->string('course_lessons')->nullable();
            $table->string('course_lessons_ar')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->string('price')->nullable();
            $table->string('price_after_discount')->nullable();
            $table->string('discount_start_date')->nullable();
            $table->string('discount_end_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
