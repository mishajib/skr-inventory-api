<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
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
            'name'       => 'bail|required|string|max:255|unique:units',
            'short_name' => 'bail|required|string|max:255|unique:units'
        ];

        if ($this->method() === 'PUT') {
            $rules['name']       = 'bail|required|string|max:255|unique:units,id,:id';
            $rules['short_name'] = 'bail|required|string|max:255|unique:units,id,:id';
        }

        return $rules;
    }
}
