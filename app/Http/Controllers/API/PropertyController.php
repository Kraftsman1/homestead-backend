<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{

    /**
     * Get all properties.
     *
     * @param GetPropertiesRequest $request Validated request data.
     *
     * @return JsonResponse
     *
     */
    public function index(Request $request)
    {
        try {

            // Start building the query to retrieve all properties
            $query = Property::query();

            $query->with('city', 'region', 'country');

            // Execute the query to retrieve properties
            $properties = $query->get();

            // Check if properties exist
            if ($properties->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No properties found.',
                ], 404);
            }

            // Paginate results from validated data
            $limit = $request->query('limit') ?? 10;
            $currentPage = $request->query('page') ?? 1;

            $properties = $query->paginate($limit, ['id', 'name', 'price', 'bedrooms', 'bathrooms', 'city_id', 'region_id', 'country_id'], 'page', $currentPage);

            // Return JSON response with properties data
            return response()->json([
                'success' => true,
                'message' => 'All properties retrieved successfully.',
                'data' => $properties,
            ], 200);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Get a property by ID.
     *
     * @param int $id The property ID.
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            // Retrieve the property by ID
            $property = Property::with('city', 'region', 'country')->find($id);

            // Check if property exists
            if (!$property) {
                return response()->json([
                    'success' => false,
                    'message' => 'Property not found.',
                ], 404);
            }

            // Return JSON response with property data
            return response()->json([
                'success' => true,
                'message' => 'Property retrieved successfully.',
                'data' => $property,
            ], 200);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Mark a property as favorite.
     *
     * @param int $id The property ID.
     *
     * @return JsonResponse
     */
    public function favorite(Request $request, $id)
    {
        try {

            // Get the authenticated user
            $user = Auth::user();

            // Get property by ID
            $property = Property::find($id);

            // Get the 'favorited' flag from the request
            $isFavorited = $request->boolean('favorited') ?? false;

            if ($isFavorited) {
                // favorite the property
                if(!$user->favoriteProperties->contains($property)) {
                    $user->favorites()->attach($property);
                }
                $message = 'Property favorited successfully.';
            } else {
                // unfavorite the property
                if($user->favorites->contains($property)) {
                    $user->favorites()->detach($property);
                }
                $message = 'Property unfavorited successfully.';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'id' => $property->id,
                    'favorited' => $isFavorited,
                ]
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
    private function handleError($e)
    {
        Log::error($e);
        return response()->json([
            'message' => 'Internal server error',
        ], 500);
    }
}
