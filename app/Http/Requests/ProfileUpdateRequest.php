<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Allow all users to make this request
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
            'firstname' => 'string|max:255',
            'lastname' => 'string|max:255',
            'username' => 'string|max:255|unique:users',
            'email' => 'email|max:255|unique:users',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'firstname.string' => 'The firstname must be a string.',
            'firstname.max' => 'The firstname must not be greater than 255 characters.',
            'lastname.string' => 'The lastname must be a string.',
            'lastname.max' => 'The lastname must not be greater than 255 characters.',
            'username.string' => 'The username must be a string.',
            'username.max' => 'The username must not be greater than 255 characters.',
            'username.unique' => 'The username has already been taken.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email must not be greater than 255 characters.',
            'email.unique' => 'The email has already been taken.',
        ];
    }
}
