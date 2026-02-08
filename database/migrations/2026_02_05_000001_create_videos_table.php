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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Display name
            $table->string('original_name'); // Original file name
            $table->string('path'); // Path in GCS bucket
            $table->string('url'); // Public URL
            $table->bigInteger('size')->nullable(); // File size in bytes
            $table->string('mime_type')->nullable();
            $table->integer('duration')->nullable(); // Duration in seconds
            $table->enum('status', ['pending', 'uploading', 'completed', 'failed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
