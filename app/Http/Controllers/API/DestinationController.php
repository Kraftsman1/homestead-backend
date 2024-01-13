<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetDestinationsRequest;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
            // Create query builder
            $query = Destination::query();
    
            // Apply filters using relationships and foreign keys
            if ($request->has('city_id')) {
                $query->whereHas('city', function ($query) use ($request) {
                    $query->where('id', $request->city_id);
                });
            }
            if ($request->has('region_id')) {
                $query->whereHas('region', function ($query) use ($request) {
                    $query->where('id', $request->region_id);
                });
            }
            if ($request->has('country_id')) {
                $query->whereHas('country', function ($query) use ($request) {
                    $query->where('id', $request->country_id);
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

            // Paginate results
            $perPage = $request->query('per_page', 5);
            $currentPage = $request->query('page', 1);

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
    
}
