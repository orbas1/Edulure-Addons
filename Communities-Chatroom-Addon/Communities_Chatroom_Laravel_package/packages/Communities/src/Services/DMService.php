<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Services;

use Illuminate\Support\Facades\DB;
use RocketAddons\Communities\Events\DMMessagePosted;
use RocketAddons\Communities\Models\DMMessage;
use RocketAddons\Communities\Models\DMParticipant;
use RocketAddons\Communities\Models\DMThread;
use RuntimeException;

class DMService
{
    public function createThread(int $creatorId, array $participantIds, string $type = 'dm', ?string $title = null): DMThread
    {
        return DB::transaction(function () use ($creatorId, $participantIds, $type, $title) {
            $thread = DMThread::create([
                'created_by' => $creatorId,
                'type' => $type,
                'title' => $title,
                'last_message_at' => now(),
            ]);

            foreach (array_unique(array_merge([$creatorId], $participantIds)) as $userId) {
                DMParticipant::create([
                    'thread_id' => $thread->id,
                    'user_id' => $userId,
                    'role' => $userId === $creatorId ? 'owner' : 'member',
                    'joined_at' => now(),
                ]);
            }

            return $thread;
        });
    }

    public function postMessage(DMThread $thread, int $userId, array $payload): DMMessage
    {
        $isParticipant = $thread->participants()->where('user_id', $userId)->exists();
        if (!$isParticipant) {
            throw new RuntimeException('Not a participant');
        }

        $message = $thread->messages()->create([
            'user_id' => $userId,
            'content' => $payload['content'],
            'metadata' => $payload['metadata'] ?? [],
        ]);

        $thread->update(['last_message_at' => now()]);
        DMMessagePosted::dispatch($message);

        return $message;
    }
}
