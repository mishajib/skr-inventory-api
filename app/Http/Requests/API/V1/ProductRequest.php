<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name'        => 'bail|required|string|max:255',
            'code'        => 'bail|required|string|unique:products',
            'cost'        => 'bail|required|numeric|min:1',
            'price'       => 'bail|required|numeric|min:1',
            'image'       => 'bail|nullable|image',
            'note'        => 'bail|nullable|string',
            'brand_id'    => 'bail|required|exists:brands,id',
            'category_id' => 'bail|required|exists:categories,id',
            'unit_id'     => 'bail|required|exists:units,id',
            'quantity'    => 'bail|required|integer',
        ];

        if ($this->method() === 'PUT') {
            $rules['code'] = 'bail|required|string|unique:products,id,:id';
            unset($rules['quantity']);
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'code'        => 'product code',
            'cost'        => 'purchase price',
            'brand_id'    => 'brand',
            'category_id' => 'category',
            'unit_id'     => 'unit',
        ];
    }
}
