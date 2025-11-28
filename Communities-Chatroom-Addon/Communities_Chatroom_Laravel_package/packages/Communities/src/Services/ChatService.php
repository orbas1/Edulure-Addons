<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Services;

use Illuminate\Support\Facades\DB;
use RocketAddons\Communities\Events\ChannelMessagePosted;
use RocketAddons\Communities\Models\Channel;
use RocketAddons\Communities\Models\ChannelMessage;
use RocketAddons\Communities\Models\ChannelMessageReaction;
use RocketAddons\Communities\Services\FileScanner\FileScannerInterface;

class ChatService
{
    public function __construct(private FileScannerInterface $fileScanner)
    {
    }

    public function postMessage(Channel $channel, int $userId, array $payload): ChannelMessage
    {
        $message = DB::transaction(function () use ($channel, $userId, $payload) {
            $message = $channel->messages()->create([
                'user_id' => $userId,
                'content' => $payload['content'],
                'metadata' => $payload['metadata'] ?? [],
            ]);

            ChannelMessagePosted::dispatch($message);
            return $message;
        });

        return $message;
    }

    public function react(ChannelMessage $message, int $userId, string $emoji): ChannelMessageReaction
    {
        return ChannelMessageReaction::firstOrCreate([
            'message_id' => $message->id,
            'user_id' => $userId,
            'emoji' => $emoji,
        ]);
    }
}
