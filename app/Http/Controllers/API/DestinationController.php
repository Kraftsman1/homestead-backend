<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        try {
            $this->validate($request, [
                'region' => 'nullable|string',
                'country' => 'nullable|string',
                'page' => 'nullable|numeric|min:1',
            ]);

            $query = Destination::query();

            // Apply filters based on validated query parameters
            if ($request->has('region')) {
                $query->where('region', $request->region);
            }
            if ($request->has('country')) {
                $query->where('country', $request->country);
            }

            // Paginate results
            $perPage = 5; // Adjust page size as needed
            $currentPage = $request->query('page', 1);

            $destinations = $query->paginate($perPage, ['*'], 'page', $currentPage);

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

}
