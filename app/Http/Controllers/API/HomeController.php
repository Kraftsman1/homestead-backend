<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{

/**
 * Search for cities, regions and countries that match the search term
 *
 * @param Request $request
 *
 * @return JsonResponse
 */
    public function search_suggestions(Request $request)
    {
        $term = $request->q;

        $citySuggestions = City::where('name', 'like', '%' . $term . '%')->get();
        $regionSuggestions = Region::where('name', 'like', '%' . $term . '%')->get();
        $countrySuggestions = Country::where('name', 'like', '%' . $term . '%')->get();

        $suggestions = collect()
            ->merge($citySuggestions->map(fn($city) => ['value' => $city->name, 'type' => 'city']))
            ->merge($regionSuggestions->map(fn($region) => ['value' => $region->name, 'type' => 'region']))
            ->merge($countrySuggestions->map(fn($country) => ['value' => $country->name, 'type' => 'country']))
            ->values() // Remove potential duplicates
            ->unique('value');

        return response()->json([
            'suggestions' => $suggestions,
        ], 200);
    }

/**
 * Search for destinations based on name, city, region or country that match the search term
 *
 * @param Request $request request data
 *
 * @return JsonResponse
 */
    public function search(Request $request)
    {

        try {
            $search = $request->q;

            $query = Destination::query();
    
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhereHas('city', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('region', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('country', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->with('city', 'region', 'country')
                ->get();
    
                if ($query->count() === 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No destinations found.',
                    ], 404);
                }
    
                $limit = $request->limit ?? 10;
                $currentPage = $request->page ?? 1;
    
                $destinations = $query->paginate($limit, ['id', 'name', 'description', 'city_id', 'region_id', 'country_id'], 'page', $currentPage);
    
                return response()->json([
                    'success' => true,
                    'data' => $destinations,
                ], 200);
        }
        catch (ValidationException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Invalid search parameters.',
            ], 400);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred.',
            ], 500);
        }

    }

}
