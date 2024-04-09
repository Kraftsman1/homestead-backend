<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSignUpRequest extends FormRequest
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
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
            'role' => 'required|string|in:admin,user'
        ];
    }

    public function messages(){

        return[
            'firstname.required'=>'Please provide a first name.',
            'lastname.required'=>'Please provide a last name.',
            'email.required'=>'Please enter an email address.',
            'email.unique'=>'This email is already registered.',
            'password.required'=>'Please provide a password.',
            'password.min'=>'Password must be at least 8 characters long.',
            'password_confirmation.required'=>'Confirm your password please.',
            'password_confirmation.same'=>'The confirmation password does not match with the password.',
            'role.required'=>'Role cannot be empty',
            'role.in'=>'Invalid role selected.',
        ];

    }

}
