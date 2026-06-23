<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('hls_path')->nullable()->after('url');
            $table->text('encryption_key')->nullable()->after('hls_path');
            $table->enum('hls_status', ['pending', 'processing', 'ready', 'failed'])->nullable()->after('status');
            $table->text('hls_error')->nullable()->after('hls_status');
        });
    }

    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn(['hls_path', 'encryption_key', 'hls_status', 'hls_error']);
        });
    }
};
