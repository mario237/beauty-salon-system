<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'start_datetime' => 'required|date|after:now',
            'services' => 'required|array|min:1',
            'services.*' => 'exists:services,id',
            'employees' => 'required|array|min:1',
            'employees.*' => 'exists:employees,id',
            'discount' => 'nullable|array',
            'discount.*' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|array',
            'discount_type.*' => 'in:percentage,flat',
            'note' => 'nullable|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
