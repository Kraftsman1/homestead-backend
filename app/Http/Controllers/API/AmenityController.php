<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Amenity;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator; 

class AmenityController extends Controller
{
    
    /**
     * Get all amenities.
     * 
     * @return JsonResponse
     */
    public function index() {
        try {
            $amenities = Amenity::all();

            return response()->json([
                'success' => true,
                'message' => 'All amenities retrieved successfully.',
                'data' => $amenities,
            ], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Get an amenity by ID.
     * 
     * @param int $id
     * 
     * @return JsonResponse
     */
    public function show($id) {
        try {
            $amenity = Amenity::find($id);

            if (!$amenity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Amenity not found.',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Amenity retrieved successfully.',
                'data' => $amenity,
            ], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Create a new amenity.
     * 
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors(),
                ], 400);
            }

            $amenity = new Amenity();
            $amenity->name = $request->name;
            $amenity->save();

            return response()->json([
                'success' => true,
                'message' => 'Amenity created successfully.',
                'data' => $amenity,
            ], 201);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Update an amenity.
     * 
     * @param Request $request
     * @param int $id
     * 
     * @return JsonResponse
     */
    public function update(Request $request, $id) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors(),
                ], 400);
            }

            $amenity = Amenity::find($id);

            if (!$amenity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Amenity not found.',
                ], 404);
            }

            $amenity->name = $request->name;
            $amenity->save();

            return response()->json([
                'success' => true,
                'message' => 'Amenity updated successfully.',
                'data' => $amenity,
            ], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Delete an amenity.
     * 
     * @param int $id
     * 
     * @return JsonResponse
     */
    public function destroy($id) {
        try {
            $amenity = Amenity::find($id);

            if (!$amenity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Amenity not found.',
                ], 404);
            }

            $amenity->delete();

            return response()->json([
                'success' => true,
                'message' => 'Amenity deleted successfully.',
            ], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }
    
    /**
     * Archive an amenity.
     * 
     * @param int $id
     * 
     * @return JsonResponse
     */
    public function archive($id) {
        try {
            $amenity = Amenity::find($id);

            if (!$amenity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Amenity not found.',
                ], 404);
            }

            $amenity->delete();

            return response()->json([
                'success' => true,
                'message' => 'Amenity archived successfully.',
            ], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }
    
}
