<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed role_id
 * @property mixed name
 * @property mixed email
 * @property mixed password
 */
class AddUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role_id' => ['required', 'string', 'max:255', 'exists:roles,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email', 'unique:users,email'],
            'password' => ['nullable', 'string', 'min:8', 'max:255'],
        ];
    }

    /**
     * make custom massages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'role_id.required' => 'Role is required!',
        ];
    }
}
