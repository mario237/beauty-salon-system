<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ReservationStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|exists:reservations,id',
            'status' => 'required|in:confirmed,cancelled',
            'reason' => 'nullable|string|max:255'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
