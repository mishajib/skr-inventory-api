<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            'name' => 'bail|required|string|max:255|unique:brands',
        ];

        if ($this->method() === 'PUT') {
            $rules['name'] = 'bail|required|string|max:255|unique:brands,id,:id';
        }

        return $rules;
    }
}
