<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_id')->constrained('communities')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('channels')->nullOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->enum('type', ['text', 'announcement', 'voice_future'])->default('text');
            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_private')->default(false);
            $table->json('settings')->nullable();
            $table->timestamps();
            $table->unique(['community_id', 'slug']);
        });

        Schema::create('channel_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('channel_id')->constrained('channels')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('content');
            $table->json('metadata')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
            $table->index(['channel_id', 'created_at']);
        });

        Schema::create('channel_message_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained('channel_messages')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('emoji', 50);
            $table->timestamps();
            $table->unique(['message_id', 'user_id', 'emoji']);
        });

        Schema::create('channel_message_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained('channel_messages')->cascadeOnDelete();
            $table->string('path');
            $table->string('original_name');
            $table->string('mime_type');
            $table->unsignedBigInteger('size');
            $table->enum('scan_status', ['pending', 'clean', 'infected', 'failed'])->default('pending');
            $table->json('scan_report')->nullable();
            $table->timestamps();
        });

        Schema::create('central_feed_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_id')->nullable()->constrained('communities')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users');
            $table->enum('type', ['post', 'announcement', 'course_event', 'system'])->default('post');
            $table->string('title')->nullable();
            $table->text('content');
            $table->json('metadata')->nullable();
            $table->string('visibility')->default('public');
            $table->timestamps();
        });

        Schema::create('central_feed_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feed_item_id')->constrained('central_feed_items')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('reaction', 50);
            $table->timestamps();
            $table->unique(['feed_item_id', 'user_id', 'reaction']);
        });

        Schema::create('central_feed_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feed_item_id')->constrained('central_feed_items')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('content');
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('central_feed_comments');
        Schema::dropIfExists('central_feed_reactions');
        Schema::dropIfExists('central_feed_items');
        Schema::dropIfExists('channel_message_attachments');
        Schema::dropIfExists('channel_message_reactions');
        Schema::dropIfExists('channel_messages');
        Schema::dropIfExists('channels');
    }
};
