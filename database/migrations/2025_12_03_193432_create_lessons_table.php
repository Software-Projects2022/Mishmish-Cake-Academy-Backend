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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete()->nullable();
            $table->string('title')->nullable();
            $table->string('title_ar')->nullable()  ;
            $table->string('icon')->nullable()  ;
            $table->string('duration')->nullable()  ;
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropIndex(['course_id']);
            $table->dropSoftDeletes();
        });
    }
};
