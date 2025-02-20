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
                Rule::unique('customers' , 'phone_number')->ignore($this->employee ?? 0),
                'regex:/^(01)(0|1|2|5)[0-9]{8}$/'
            ],
            'department_id' => ['required', Rule::exists('departments', 'id')],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
