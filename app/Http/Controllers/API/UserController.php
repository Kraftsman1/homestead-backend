<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\ProfilePicture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Get authenticated user profile.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();

            return response()->json([
                'success' => true,
                'message' => 'Profile retrieved successfully.',
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Update authenticated user profile.
     *
     * @param ProfileUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function update(ProfileUpdateRequest $request)
    {
        try {
            $user = Auth::user();
            $validated = $request->validated();
            $user->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully.',
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Upload profile picture for authenticated user.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update_profile_picture(Request $request)
    {
        try {
            $user = Auth::user();

            // Check if file exists and is not empty
            if (!$request->hasFile('profile_picture') || $request->file('profile_picture')->getSize() == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No file uploaded or file is empty.',
                ], 422);
            }

            // Validate uploaded file
            $validated = $request->validate([
                'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Generate unique filename
            $filename = time() . '.' . $request->file('profile_picture')->getClientOriginalExtension();

            // Store file in public storage
            $path = $request->file('profile_picture')->storeAs('profile_pictures', $filename, 'public');

            // Generate image URL
            $imageUrl = Storage::url($path);

            // Create or update profile picture record for user
            $profilePicture = $user->profilePicture ?: new ProfilePicture();
            $profilePicture->image_path = $filename;
            $profilePicture->image_url = $imageUrl;
            $user->profilePicture()->save($profilePicture);

            return response()->json([
                'success' => true,
                'message' => 'Profile picture uploaded successfully.',
                'profile_picture' => [
                    'image_path' => $filename,
                    'image_url' => $imageUrl,
                ]
            ], 200);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Change password for authenticated user.
     *
     * @param ChangePasswordRequest $request
     *
     * @return JsonResponse
     */
    public function change_password(Request $request)
    {
        try {
            $user = Auth::user();
            $validated = $request->all();

            if (!Hash::check($validated['old_password'], $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Old password is incorrect.',
                ], 422);
            }

            $user->update([
                'password' => Hash::make($validated['new_password']),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully.',
            ], 200);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Get authenticated user favorite properties.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function favorites(Request $request)
    {
        try {
            // Get authenticated user
            $user = Auth::user();

            // Check if user has favorite properties
            if ($user->favorites->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'No favorited properties found.'
                ], 200);
            }

            // Get user favorite properties
            $favorites = $user->favorites;

            return response()->json([
                'success' => true,
                'message' => 'Favorites retrieved successfully.',
                'data' => $favorites,
            ], 200);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Handle errors and return JSON response.
     *
     * @param \Exception $e
     *
     * @return JsonResponse
     */
    private function handleError(\Exception $e)
    {
        Log::error($e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'An unexpected error occurred. Please try again later.',
        ], 500);
    }
}
