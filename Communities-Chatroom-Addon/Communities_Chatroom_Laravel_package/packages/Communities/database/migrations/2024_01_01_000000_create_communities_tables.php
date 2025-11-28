<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('communities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users');
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('visibility', ['public', 'private', 'hidden'])->default('public');
            $table->string('cover_image_path')->nullable();
            $table->string('icon_path')->nullable();
            $table->unsignedBigInteger('default_role_id')->nullable();
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->boolean('is_featured')->default(false);
            $table->json('settings')->nullable();
            $table->timestamps();
            $table->foreign('default_role_id')->references('id')->on('community_roles')->nullOnDelete();
        });

        Schema::create('community_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_id')->nullable()->constrained('communities')->nullOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->json('permissions')->nullable();
            $table->timestamps();
            $table->unique(['community_id', 'slug']);
        });

        Schema::create('community_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_id')->constrained('communities')->cascadeOnDelete();
            $table->unsignedBigInteger('course_id');
            $table->enum('link_type', ['primary', 'related', 'live_classroom'])->default('primary');
            $table->timestamps();
            $table->index('course_id');
        });

        Schema::create('community_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_id')->constrained('communities')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('role_id')->nullable()->constrained('community_roles')->nullOnDelete();
            $table->timestamp('joined_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->enum('status', ['active', 'muted', 'banned', 'pending'])->default('active');
            $table->string('ban_reason')->nullable();
            $table->timestamp('ban_expires_at')->nullable();
            $table->timestamps();
            $table->unique(['community_id', 'user_id']);
        });

        Schema::create('community_pricing_tiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_id')->constrained('communities')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('currency', 3)->default('USD');
            $table->enum('billing_interval', ['monthly', 'yearly', 'once'])->default('monthly');
            $table->json('features')->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['community_id', 'slug']);
        });

        Schema::create('community_member_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_id')->constrained('communities')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('pricing_tier_id')->constrained('community_pricing_tiers')->cascadeOnDelete();
            $table->enum('status', ['active', 'past_due', 'canceled', 'expired'])->default('active');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->string('external_subscription_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('community_member_subscriptions');
        Schema::dropIfExists('community_pricing_tiers');
        Schema::dropIfExists('community_members');
        Schema::dropIfExists('community_courses');
        Schema::dropIfExists('community_roles');
        Schema::dropIfExists('communities');
    }
};
