<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'date'                  => 'bail|required|date_format:Y-m-d H:i:s',
            'invoice_no'            => 'bail|required|string|unique:purchases',
            'supplier_id'           => 'bail|required|exists:suppliers,id',
            'note'                  => 'bail|nullable|string',
            'products'              => 'bail|required|array',
            'products.*'            => 'bail|required|array',
            'products.*.product_id' => 'bail|required|exists:products,id',
            'products.*.qty'        => 'bail|required|integer|min:1',
            'products.*.price'      => 'bail|required|numeric|min:1',
        ];

        if ($this->method() === 'PUT') {
            $rules['invoice_no'] = 'bail|required|string|unique:purchases,id,:id';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'supplier_id'           => 'supplier',
            'invoice_no'            => 'invoice number',
            'products.*.product_id' => 'product',
            'products.*.qty'        => 'quantity',
        ];
    }
}
