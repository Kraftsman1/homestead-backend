<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'remember_me' => 'boolean'
        ];
    }

    public function messages() {

        return [
            'email.required' => 'Please enter you email address.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Please enter your password.' ,
            'password.min' => 'Your password must be at least 8 characters long.',
        ];

    }
}
