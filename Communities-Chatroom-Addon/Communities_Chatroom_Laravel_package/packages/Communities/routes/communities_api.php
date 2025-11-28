<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use RocketAddons\Communities\Http\Controllers\API\ChannelController;
use RocketAddons\Communities\Http\Controllers\API\ChannelMessageController;
use RocketAddons\Communities\Http\Controllers\API\CommunityController;
use RocketAddons\Communities\Http\Controllers\API\DMController;
use RocketAddons\Communities\Http\Controllers\API\HeatmapController;
use RocketAddons\Communities\Http\Controllers\API\LeaderboardController;
use RocketAddons\Communities\Http\Controllers\API\ModerationController;

Route::middleware(['auth', 'communities.enabled'])->group(function () {
    Route::get('/communities', [CommunityController::class, 'index']);
    Route::post('/communities', [CommunityController::class, 'store']);
    Route::post('/communities/{community}/join', [CommunityController::class, 'join']);
    Route::post('/communities/{community}/leave', [CommunityController::class, 'leave']);

    Route::middleware('communities.feature:central_feed')->group(function () {
        Route::get('/communities/{community}/feed', [CommunityController::class, 'feed'])->middleware('communities.membership');
        Route::post('/communities/{community}/feed', [CommunityController::class, 'postToFeed'])
            ->middleware(['communities.membership', 'communities.can_post']);
    });

    Route::middleware(['communities.feature:channels', 'communities.membership'])->group(function () {
        Route::get('/channels/{channel}/messages', [ChannelMessageController::class, 'index']);
        Route::post('/channels/{channel}/messages', [ChannelMessageController::class, 'store'])
            ->middleware('communities.can_post');
        Route::post('/channels/{channel}/messages/{message}/react', [ChannelMessageController::class, 'react'])
            ->middleware('communities.can_post');
    });

    Route::middleware('communities.feature:dm')->group(function () {
        Route::post('/dm/threads', [DMController::class, 'store']);
        Route::get('/dm/threads', [DMController::class, 'index']);
        Route::get('/dm/threads/{thread}/messages', [DMController::class, 'messages']);
        Route::post('/dm/threads/{thread}/messages', [DMController::class, 'storeMessage']);
    });

    Route::get('/communities/{community}/leaderboard', [LeaderboardController::class, 'show'])
        ->middleware('communities.feature:leaderboard');
    Route::get('/users/{user}/heatmap', [HeatmapController::class, 'show'])
        ->middleware('communities.feature:heatmap');

    Route::post('/moderation/reports', [ModerationController::class, 'store'])
        ->middleware('communities.feature:bad_word_filter');
});
