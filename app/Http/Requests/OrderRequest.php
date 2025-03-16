<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer_id'          => 'required|exists:customers,id',
            'products'             => 'required|array|min:1',
            'products.*.id'        => 'required|exists:products,id',
            'products.*.quantity'  => 'required|integer|min:1',
            'products.*.price'     => 'required|numeric|min:0',
            'products.*.discount'  => 'nullable|numeric|min:0',
            'products.*.discount_type' => 'nullable|in:flat,percentage',
            'discount'             => 'nullable|numeric|min:0',
            'discount_type'        => 'nullable|in:flat,percentage',
            'payment_method'       => 'required|in:cash,credit_card,bank_transfer',
            'notes'                => 'nullable|string|max:500',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
    public function messages(): array
    {
        return [
            'customer_id.required' => 'Please select a customer',
            'customer_id.exists' => 'The selected customer does not exist',
            'products.required' => 'At least one product is required',
            'products.min' => 'At least one product is required',
            'products.*.id.required' => 'Product is required',
            'products.*.id.exists' => 'Selected product does not exist',
            'products.*.quantity.required' => 'Product quantity is required',
            'products.*.quantity.min' => 'Product quantity must be at least 1',
            'products.*.price.required' => 'Product price is required',
            'products.*.price.min' => 'Product price cannot be negative',
            'payment_method.required' => 'Payment method is required',
            'payment_method.in' => 'Invalid payment method selected',
        ];
    }
}
