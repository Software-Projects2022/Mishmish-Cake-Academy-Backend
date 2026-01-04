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
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete()->nullable();
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
        Schema::dropIfExists('chapters');
        Schema::table('chapters', function (Blueprint $table) {
            $table->dropForeign(['lesson_id']);
            $table->dropIndex(['lesson_id']);
            $table->dropSoftDeletes();
        });
    }
};
