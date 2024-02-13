<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DestinationController extends Controller
{
    /**
     * Get all destinations.
     *
     * @param GetDestinationsRequest $request Validated request data.
     *
     * @return JsonResponse
     *
     */
    public function index(Request $request)
    {
        try {
            // Create query builder
            $query = Destination::query();

            // Eager load relationships for efficiency
            $query->with('city', 'region', 'country');

            // If no destinations are found, return 404 directly
            if ($query->count() === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No destinations found.',
                ], 404);
            }

            // Paginate results from validated data
            $limit = $request->query('limit') ?? 10;
            $currentPage = $request->query('page') ?? 1;

            $destinations = $query->paginate($limit, ['id', 'name', 'description', 'city_id', 'region_id', 'country_id'], 'page', $currentPage);

            return response()->json([
                'success' => true,
                'message' => 'All destinations retrieved successfully.',
                'data' => $destinations,
            ], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Get a destination by ID.
     *
     * @param int $id The destination ID.
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        try {

            // If no destination is found, return 404 directly
            if (!Destination::where('id', $id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Destination does not exist.',
                ], 404);
            }

            $destination = Destination::with('city', 'region', 'country', 'properties', 'images', 'amenities')->findOrFail($id);

            // Return destination
            return response()->json([
                'success' => true,
                'message' => 'Destination retrieved successfully.',
                'data' => $destination,
            ], 200);

        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Favorite or unfavorite a destination.
     *
     * @param Request $request The request object.
     * @param int $id The destination ID.
     *
     * @return JsonResponse
     */
    public function favorite(Request $request, $id)
    {
        try {
            // Get Authenticated user
            $user = Auth::user();

            // Get destination
            $destination = Destination::findOrFail($id);

            // Get the 'favorited' flag from the request
            $isFavorited = $request->boolean('favorited') ?? false;

            if ($isFavorited) {
                // Favorite the destination
                if (!$user->favorites->contains($destination)) {
                    $user->favorites()->attach($destination);
                }
                $message = 'Destination favorited successfully.';
            } else {
                // Unfavorite the destination
                if ($user->favorites->contains($destination)) {
                    $user->favorites()->detach($destination);
                }
                $message = 'Destination unfavorited successfully.';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'id' => $destination->id,
                    // Update favorite status response
                    'favorited' => $isFavorited,
                ],
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Destination not found.',
            ], 404);
        } catch (\Exception $e) {
            // Log error for debugging
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occured. Please try again later.',
            ], 500);
        }
    }

}
