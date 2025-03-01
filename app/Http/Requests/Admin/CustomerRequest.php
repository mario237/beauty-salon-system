<?php

namespace App\Http\Requests\Admin;

use App\Enums\CustomerSource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'phone_number' => [
                'required' , 'numeric' ,
                Rule::unique('customers' , 'phone_number')
                    ->whereNull('deleted_at')->ignore($this->customer ?? 0),
                'regex:/^(01)(0|1|2|5)[0-9]{8}$/'
            ],
            'source' => ['required', Rule::in(CustomerSource::values())],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
