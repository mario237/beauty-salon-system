<?php

namespace App\Http\Requests\Admin;

use App\Enums\CustomerSource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', Rule::unique('departments', 'name')
                ->whereNull('deleted_at')->ignore($this->department ?? 0)
                ->whereNull('deleted_at')],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
