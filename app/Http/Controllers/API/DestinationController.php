<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetDestinationsRequest;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class DestinationController extends Controller
{
    /**
     * Get all destinations.
     *
     * @param GetDestinationsRequest $request Validated request data.
     *
     * @return JsonResponse
     *
     * @throws JsonValidationException If validation fails.
     */
    public function index(GetDestinationsRequest $request)
    {
        try {
            $validated = $request->validated();
    
            // Create query builder
            $query = Destination::query();
    
            // Apply filters using relationships and foreign keys
            if (isset($validated['city_id']) && $validated['city_id']) {
                $query->whereHas('city', function ($query) use ($validated) {
                    $query->where('id', $validated['city_id']);
                });
            }
            if (isset($validated['region_id']) && $validated['region_id']) {
                $query->whereHas('region', function ($query) use ($validated) {
                    $query->where('id', $validated['region_id']);
                });
            }
            if (isset($validated['country_id']) && $validated['country_id']) {
                $query->whereHas('country', function ($query) use ($validated) {
                    $query->where('id', $validated['country_id']);
                });
            }
    
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
            $perPage = $validated['per_page'] ?? 10;
            $currentPage = $validated['page'] ?? 1;
    
            $destinations = $query->paginate($perPage, ['id', 'name', 'description', 'city_id', 'region_id', 'country_id'], 'page', $currentPage);
    
            return response()->json([
                'success' => true,
                'message' => 'All destinations retrieved successfully.',
                'data' => $destinations,
            ], 200);
    
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Invalid query parameters',
                'errors' => $e->errors(),
            ], 400);
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
            $destination = Destination::with('city', 'region', 'country', 'properties', 'images', 'amenities')->findOrFail($id);

            // If no destination is found, return 404 directly
            if (!$destination) {
                return response()->json([
                    'success' => false,
                    'message' => 'Destination not found.',
                ], 404);
            }

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
            $isFavorited = $request->get('favorited') ?? false;

            if ($isFavorited) {
                // Favorite the destination
                if (!$user->favorites->contains($destination)) {
                    $user->favorites()->attach($destination);
                }
                $message = 'Destination favorited.';
            } else {
                // Unfavorite the destination
                if ($user->favorites->contains($destination)) {
                    $user->favorites()->detach($destination);
                }
                $message = 'Destination unfavorited.';
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
