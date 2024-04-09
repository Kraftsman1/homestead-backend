<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserSignUpRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Events\UserCreated;

class AuthController extends Controller
{

    /**
     * Create User Account.
     *
     * @param UserSignUpRequest $request Validated user signup data.
     *
     * @return JsonResponse
     *
     * @throws JsonValidationException If validation fails.
     */

    public function signup(UserSignUpRequest $request)
    {
        try {
            $validated = $request->validated();

            // Check if existing user with same email
            if (User::where('email', $validated['email'])->exists()) {
                return response()->json([
                    'message' => 'User with this email already exists!',
                ], 409);
            }

            // Hash password before creating user
            $validated['password'] = Hash::make($validated['password']);

            // Create user with the validated data
            $user = User::create($validated);

            // Fire event to create user attributes
            event(new UserCreated($user));

            if ($user) {
                $token = $user->createToken('Personal Access Token')->plainTextToken;

                // Determine and include user role if logic exists
                $role = isset($user->role) ? $user->role : null;

                return response()->json([
                    'message' => 'Your account has been created successfully!',
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'role' => $role,
                ], 201);
            } else {
                return response()->json([
                    'error' => 'An unexpected error occurred while creating your account. Please try again later.',
                ], 500);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Please correct the following errors:',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Login User
     *
     * @param UserLoginRequest $request Validated user login data.
     *
     * @return JsonResponse
     *
     * @throws JsonValidationException If validation fails.
     */
    public function login(UserLoginRequest $request)
    {
        try {
            $validated = $request->validated();
    
            // Fetch user by email
            $user = User::where('email', $validated['email'])->first();
    
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Invalid email or password.',
                ], 401);
            }
    
            // Generate and return token with optional user information
            $token = $user->createToken('Personal Access Token')->plainTextToken;
    
            $response = [
                'message' => 'Successfully logged in!',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'role' => $user->role,
                'user' => [
                    'id' => $user->id,
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'email' => $user->email,
                ]
            ];
    
            return response()->json($response, 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Please correct the following errors:',
                'errors' => $e->errors(),
            ], 422);
        }
    }
    
}
