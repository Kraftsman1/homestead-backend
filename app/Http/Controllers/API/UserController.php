<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    
    // Show all favorites for a user
    public function favorites(Request $request)
    {

        try {
            // Get authenticated user
            $user = Auth::user();

            // Eager load relationships for efficiency and avoid multiple queries
            $favorites = $user->favorites()->with('images')->get();

            $data = [];

            foreach ($favorites as $favorite) {
                $data[] = [
                    'id' => $favorite->id,
                    'name' => $favorite->name,
                    'images' => $favorite->images->map(function ($image) {
                        return [
                            'url' => $image->image_url,
                        ];
                    }),
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Favorites retrieved successfully.',
                'data' => $data,
            ], 200);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
    }
    
}
