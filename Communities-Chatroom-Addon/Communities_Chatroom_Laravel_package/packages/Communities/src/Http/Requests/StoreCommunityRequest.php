<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommunityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'alpha_dash', 'max:255'],
            'description' => ['nullable', 'string'],
            'visibility' => ['required', 'in:public,private,hidden'],
        ];
    }
}
