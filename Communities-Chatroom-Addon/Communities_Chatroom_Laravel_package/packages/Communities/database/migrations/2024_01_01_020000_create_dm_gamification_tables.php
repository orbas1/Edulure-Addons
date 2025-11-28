<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dm_threads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users');
            $table->enum('type', ['dm', 'group'])->default('dm');
            $table->string('title')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();
        });

        Schema::create('dm_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thread_id')->constrained('dm_threads')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('role', ['owner', 'member'])->default('member');
            $table->timestamp('joined_at')->nullable();
            $table->timestamp('left_at')->nullable();
            $table->timestamps();
            $table->unique(['thread_id', 'user_id']);
        });

        Schema::create('dm_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thread_id')->constrained('dm_threads')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('content');
            $table->json('metadata')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
            $table->index(['thread_id', 'created_at']);
        });

        Schema::create('dm_message_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained('dm_messages')->cascadeOnDelete();
            $table->string('path');
            $table->string('original_name');
            $table->string('mime_type');
            $table->unsignedBigInteger('size');
            $table->enum('scan_status', ['pending', 'clean', 'infected', 'failed'])->default('pending');
            $table->json('scan_report')->nullable();
            $table->timestamps();
        });

        Schema::create('gamification_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedBigInteger('total_points')->default(0);
            $table->unsignedInteger('level')->default(1);
            $table->unsignedBigInteger('xp')->default(0);
            $table->timestamp('last_awarded_at')->nullable();
            $table->json('settings')->nullable();
            $table->timestamps();
            $table->unique('user_id');
        });

        Schema::create('gamification_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('community_id')->nullable()->constrained('communities')->nullOnDelete();
            $table->string('type');
            $table->integer('points');
            $table->json('metadata')->nullable();
            $table->timestamp('occurred_at');
            $table->timestamps();
        });

        Schema::create('leaderboard_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_id')->nullable()->constrained('communities')->nullOnDelete();
            $table->enum('period', ['daily', 'weekly', 'monthly', 'all_time']);
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->json('data');
            $table->timestamps();
        });

        Schema::create('activity_heatmaps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('community_id')->constrained('communities')->cascadeOnDelete();
            $table->date('date');
            $table->json('hourly_counts');
            $table->timestamps();
            $table->unique(['user_id', 'community_id', 'date']);
        });

        Schema::create('moderation_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->constrained('users');
            $table->string('target_type');
            $table->unsignedBigInteger('target_id');
            $table->text('reason');
            $table->enum('status', ['open', 'reviewing', 'resolved', 'dismissed'])->default('open');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->text('resolution_notes')->nullable();
            $table->timestamps();
            $table->index(['target_type', 'target_id']);
        });

        Schema::create('bad_words', function (Blueprint $table) {
            $table->id();
            $table->string('word');
            $table->enum('severity', ['low', 'medium', 'high'])->default('low');
            $table->string('replacement')->nullable();
            $table->timestamps();
            $table->unique('word');
        });

        Schema::create('user_moderation_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('community_id')->nullable()->constrained('communities')->nullOnDelete();
            $table->enum('action', ['mute', 'ban', 'warning']);
            $table->text('reason');
            $table->timestamp('expires_at')->nullable();
            $table->foreignId('performed_by')->constrained('users');
            $table->timestamps();
        });

        Schema::create('file_scan_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('attachment_type');
            $table->unsignedBigInteger('attachment_id');
            $table->enum('status', ['pending', 'running', 'done', 'failed'])->default('pending');
            $table->json('result')->nullable();
            $table->timestamps();
            $table->index(['attachment_type', 'attachment_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('file_scan_jobs');
        Schema::dropIfExists('user_moderation_actions');
        Schema::dropIfExists('bad_words');
        Schema::dropIfExists('moderation_reports');
        Schema::dropIfExists('activity_heatmaps');
        Schema::dropIfExists('leaderboard_snapshots');
        Schema::dropIfExists('gamification_events');
        Schema::dropIfExists('gamification_profiles');
        Schema::dropIfExists('dm_message_attachments');
        Schema::dropIfExists('dm_messages');
        Schema::dropIfExists('dm_participants');
        Schema::dropIfExists('dm_threads');
    }
};
