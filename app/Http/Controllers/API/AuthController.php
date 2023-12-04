<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * Create User
     * 
     * @param [string] firstname
     * @param [string] lastname
     * @param [string] email
     * @param [string] password
     * @param [string] password_confirmation
     * @param [string] role
     * @return [string] message
     */

    public function signup(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
            'role' => 'required|string|in:admin,customer'
        ]);

        $user = new User([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);

        if($user->save()){
            $token = $user->createToken('Personal Access Token')->plainTextToken;

            return response()->json([
                'message' => 'Successfully created user!',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'role' => $user->role
            ], 201);
        }
        else{
            return response()->json([
                'message' => 'Error creating user!'
            ], 401);
        }
    }

    /**
     * Login User
     * 
     * @param [string] email
     * @param [string] password
     * @param [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] role
     */
    public function login(Request $request) {

        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'remember_me' => 'boolean'
        ]);

        $user = User::where('email', $request->email)->first();

        if($user){
            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken('Personal Access Token')->plainTextToken;

                return response()->json([
                    'message' => 'Successfully logged in!',
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'role' => $user->role
                ], 201);
            }
            else{
                return response()->json([
                    'message' => 'Invalid User Credentials!'
                ], 401);
            }
        }
        else{
            return response()->json([
                'message' => 'User with these credentials does not exist!'
            ], 401);
        }

    }
    
}
