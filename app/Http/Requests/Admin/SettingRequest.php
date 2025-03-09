<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'key' => ['required', Rule::exists('settings', 'key')],
            'value' => ['required', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
