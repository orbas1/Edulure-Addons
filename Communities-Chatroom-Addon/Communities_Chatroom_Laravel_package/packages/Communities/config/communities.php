<?php

declare(strict_types=1);

return [
    /**
     * Master enable flag for the addon.
     */
    'enabled' => env('COMMUNITIES_ENABLED', true),

    'features' => [
        'leaderboard' => true,
        'central_feed' => true,
        'channels' => true,
        'gamification' => true,
        'dm' => true,
        'heatmap' => true,
        'pricing_tiers' => true,
        'chatroom' => true,
        'file_scanning' => true,
        'bad_word_filter' => true,
    ],

    /**
     * Models used by the package.
     */
    'user_model' => env('COMMUNITIES_USER_MODEL', '\\App\\Models\\User'),
    'course_model' => env('COMMUNITIES_COURSE_MODEL', '\\App\\Models\\Webinar'),

    /**
     * Payment gateway adapter to bridge into RocketLMS checkout.
     */
    'payment_gateway_adapter' => null,

    /**
     * Notification channel name for broadcasting package notifications.
     */
    'notification_channel' => 'communities',

    'chat' => [
        'driver' => env('COMMUNITIES_CHAT_DRIVER', 'broadcast'),
        'broadcast_prefix' => env('COMMUNITIES_CHAT_PREFIX', 'communities'),
        'max_message_length' => 5000,
        'max_attachments' => 5,
        'max_attachment_size' => 5 * 1024 * 1024,
    ],

    'file_scanner' => [
        'driver' => env('COMMUNITIES_FILE_SCANNER', 'null'),
        'allowed_mimetypes' => ['image/jpeg', 'image/png', 'application/pdf'],
        'max_file_size' => 10 * 1024 * 1024,
        'clamav' => [
            'host' => env('CLAMAV_HOST', '127.0.0.1'),
            'port' => env('CLAMAV_PORT', 3310),
        ],
        'http' => [
            'endpoint' => env('FILE_SCANNER_ENDPOINT'),
            'api_key' => env('FILE_SCANNER_API_KEY'),
        ],
    ],

    'moderation' => [
        'bad_words_path' => resource_path('bad-words.txt'),
        'bad_words' => [],
        'replacement' => '*',
        'actions' => [
            'on_detect' => 'censor',
            'auto_mute_threshold' => 3,
            'auto_ban_threshold' => 5,
        ],
    ],

    'gamification' => [
        'points' => [
            'post_message' => 2,
            'reply_message' => 1,
            'receive_reaction' => 1,
            'start_dm' => 1,
            'join_community' => 5,
            'complete_course_in_linked_community' => 20,
        ],
        'level_thresholds' => [0, 100, 250, 500, 1000, 2000],
    ],

    'pricing' => [
        'enable_per_community_subscriptions' => true,
        'default_currency' => 'USD',
        'gateways' => [
            'stripe' => 'stripe',
            'paypal' => 'paypal',
        ],
    ],
];
