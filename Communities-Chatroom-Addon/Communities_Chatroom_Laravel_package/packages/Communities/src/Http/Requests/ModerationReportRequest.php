<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModerationReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'target_type' => ['required', 'string'],
            'target_id' => ['required', 'integer'],
            'reason' => ['required', 'string'],
        ];
    }
}
