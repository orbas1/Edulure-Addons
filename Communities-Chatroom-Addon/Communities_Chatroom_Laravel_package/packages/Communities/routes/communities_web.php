<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use RocketAddons\Communities\Http\Controllers\Web\AdminPageController;
use RocketAddons\Communities\Http\Controllers\Web\ChannelPageController;
use RocketAddons\Communities\Http\Controllers\Web\CommunityPageController;
use RocketAddons\Communities\Http\Controllers\Web\DMPageController;

Route::middleware(['web', 'auth', 'communities.enabled'])->group(function () {
    Route::get('/communities', [CommunityPageController::class, 'index'])->name('communities.index');
    Route::post('/communities', [CommunityPageController::class, 'store'])->name('communities.store');
    Route::get('/communities/{community}', [CommunityPageController::class, 'show'])->name('communities.show');
    Route::put('/communities/{community}', [CommunityPageController::class, 'update'])->name('communities.update');
    Route::post('/communities/{community}/join', [CommunityPageController::class, 'join'])->name('communities.join');
    Route::post('/communities/{community}/leave', [CommunityPageController::class, 'leave'])->name('communities.leave');

    Route::get('/communities/{community}/channels/{channel}', [ChannelPageController::class, 'show'])
        ->middleware('communities.membership')
        ->name('communities.channels.show');

    Route::middleware('communities.feature:dm')->group(function () {
        Route::get('/dm', [DMPageController::class, 'index'])->name('dm.index');
        Route::post('/dm', [DMPageController::class, 'create'])->name('dm.create');
        Route::get('/dm/{thread}', [DMPageController::class, 'show'])->name('dm.show');
    });

    Route::prefix('admin/communities')->middleware('can:admin')->group(function () {
        Route::get('/', [AdminPageController::class, 'index'])->name('communities.admin.index');
        Route::get('/settings', [AdminPageController::class, 'settings'])->name('communities.admin.settings');
        Route::post('/settings', [AdminPageController::class, 'saveSettings'])->name('communities.admin.settings.save');
        Route::get('/list', [AdminPageController::class, 'communities'])->name('communities.admin.communities');
        Route::post('/{community}/deactivate', [AdminPageController::class, 'deactivate'])->name('communities.admin.deactivate');
        Route::get('/moderation', [AdminPageController::class, 'moderation'])->name('communities.admin.moderation');
        Route::post('/moderation/{report}/resolve', [AdminPageController::class, 'resolveReport'])->name('communities.admin.moderation.resolve');
        Route::post('/moderation/{report}/ban', [AdminPageController::class, 'banFromReport'])->name('communities.admin.moderation.ban');
        Route::get('/gamification', [AdminPageController::class, 'gamification'])->name('communities.admin.gamification');
        Route::post('/gamification', [AdminPageController::class, 'saveGamification'])->name('communities.admin.gamification.save');
    });
});
