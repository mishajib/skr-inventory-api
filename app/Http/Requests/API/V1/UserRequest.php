<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UserRequest extends FormRequest
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
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'nullable|boolean',
        ];

        if ($this->method() === 'PUT') {
            $rules['email']    = 'required|string|email|max:255|unique:users,id,:id';
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        return $rules;
    }

    public function validated($key = null, $default = null)
    {
        if ($this->has('password') && $this->filled('password')) {
            return array_merge(parent::validated(), ['password' => Hash::make($this->input('password'))]);
        }

        $data = parent::validated($key, $default);

        unset($data['password'], $data['password_confirmation']);

        return $data;
    }
}
