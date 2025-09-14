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
        Schema::table('chats', function (Blueprint $table) {
            // Add indexes for better query performance
            $table->index(['user_id', 'created_at'], 'chats_user_created_index');
            $table->index(['session_id', 'created_at'], 'chats_session_created_index');
            $table->index(['sender', 'created_at'], 'chats_sender_created_index');
            $table->index('created_at', 'chats_created_at_index');
            
            // Add full-text index for message search (if supported)
            if (DB::getDriverName() === 'mysql') {
                $table->fullText(['message'], 'chats_message_fulltext');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            // Drop indexes
            $table->dropIndex('chats_user_created_index');
            $table->dropIndex('chats_session_created_index');
            $table->dropIndex('chats_sender_created_index');
            $table->dropIndex('chats_created_at_index');
            
            // Drop full-text index if exists
            if (DB::getDriverName() === 'mysql') {
                $table->dropFullText('chats_message_fulltext');
            }
        });
    }
};