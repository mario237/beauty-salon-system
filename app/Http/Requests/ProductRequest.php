<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        $imageExistenceRule = $this->routeIs('admin.products.update') ?
            'sometimes|' : 'required|';
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:1',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'images' => $imageExistenceRule .'array',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
