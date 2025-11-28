<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDMThreadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'in:dm,group'],
            'title' => ['nullable', 'string', 'max:255'],
            'participants' => ['required', 'array', 'min:1'],
            'participants.*' => ['integer'],
        ];
    }
}
