<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'in:post,announcement,course_event,system'],
            'title' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'visibility' => ['nullable', 'string', 'max:50'],
            'metadata' => ['nullable', 'array'],
        ];
    }
}
