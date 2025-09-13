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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->index(); // Untuk mengelompokkan percakapan
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('sender', ['user', 'ai']); // Siapa yang mengirim pesan
            $table->text('message'); // Isi pesan
            $table->json('metadata')->nullable(); // Data tambahan seperti timestamp, dll
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
