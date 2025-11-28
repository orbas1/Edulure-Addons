<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChannelMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:' . config('communities.chat.max_message_length')],
            'metadata' => ['nullable', 'array'],
        ];
    }
}
