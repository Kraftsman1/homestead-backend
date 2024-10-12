<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class PropertyTypeController extends Controller
{
    /**
     * Get all property types.
     * 
     * @return JsonResponse
     */
    public function index() {
        try {
            $propertyTypes = PropertyType::all();

            return response()->json([
                'success' => true,
                'message' => 'All property types retrieved successfully.',
                'data' => $propertyTypes,
            ], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Get a property type by ID.
     * 
     * @param int $id
     * 
     * @return JsonResponse
     */
    public function show($id) {
        try {
            $propertyType = PropertyType::find($id);

            if (!$propertyType) {
                return response()->json([
                    'success' => false,
                    'message' => 'Property type not found.',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Property type retrieved successfully.',
                'data' => $propertyType,
            ], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Create a new property type.
     * 
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function store(Request $request) {
        try {
            $request->validate([
                'name' => 'required|string',
            ]);

            $propertyType = PropertyType::create([
                'name' => $request->name,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Property type created successfully.',
                'data' => $propertyType,
            ], 201);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Update a property type.
     * 
     * @param Request $request
     * @param int $id
     * 
     * @return JsonResponse
     */
    public function update(Request $request, $id) {
        try {

            $request->validate([
                'name' => 'required|string',
            ]);
            
            $propertyType = PropertyType::find($id);

            if (!$propertyType) {
                return response()->json([
                    'success' => false,
                    'message' => 'Property type not found.',
                ], 404);
            }



            $propertyType->name = $request->name;
            $propertyType->save();

            return response()->json([
                'success' => true,
                'message' => 'Property type updated successfully.',
                'data' => $propertyType,
            ], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }

    }

    /**
     * Archive a property type.
     * 
     * @param int $id
     * 
     * @return JsonResponse
     */
    public function archive($id) {
        try {
            $propertyType = PropertyType::find($id);

            if (!$propertyType) {
                return response()->json([
                    'success' => false,
                    'message' => 'Property type not found.',
                ], 404);
            }

            $propertyType->delete();

            return response()->json([
                'success' => true,
                'message' => 'Property type archived successfully.',
            ], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Restore a property type.
     * 
     * @param int $id
     * 
     * @return JsonResponse
     */
    public function restore($id) {
        try {
            $propertyType = PropertyType::withTrashed()->find($id);

            if (!$propertyType) {
                return response()->json([
                    'success' => false,
                    'message' => 'Property type not found.',
                ], 404);
            }

            $propertyType->restore();

            return response()->json([
                'success' => true,
                'message' => 'Property type restored successfully.',
            ], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Permanently delete a property type.
     * 
     * @param int $id
     * 
     * @return JsonResponse
     */
    public function destroy($id) {
        try {
            $propertyType = PropertyType::withTrashed()->find($id);

            if (!$propertyType) {
                return response()->json([
                    'success' => false,
                    'message' => 'Property type not found.',
                ], 404);
            }

            $propertyType->forceDelete();

            return response()->json([
                'success' => true,
                'message' => 'Property type deleted successfully.',
            ], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }
    
    /**
     * Handle error response.
     *
     * @param Exception $e
     *
     * @return JsonResponse
     */
    private function handleError($e)
    {
        Log::error($e->getMessage());
        return response()->json([
            'message' => 'Internal server error',
        ], 500);
    }

}
