<?php

namespace App\Http\Requests\Admin;

use App\Enums\CustomerSource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'phone_number' => [
                'required' , 'numeric' ,
                Rule::unique('employees' , 'phone_number')
                    ->whereNull('deleted_at')->ignore($this->employee ?? 0),
                'regex:/^(01)(0|1|2|5)[0-9]{8}$/'
            ],
            'services' => ['required','array'],
            'services.*' => [Rule::exists('services', 'id')->whereNull('deleted_at')],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
