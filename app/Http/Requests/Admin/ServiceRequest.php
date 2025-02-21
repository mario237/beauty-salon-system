<?php

namespace App\Http\Requests\Admin;

use App\Enums\CustomerSource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'duration' => ['required', 'integer', 'min:1'],
            'department_id' => ['required', Rule::exists('departments', 'id')],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
