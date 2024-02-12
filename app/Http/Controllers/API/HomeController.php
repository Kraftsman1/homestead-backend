<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\City;
use App\Models\Region;
use App\Models\Country;
use Illuminate\Http\Request;

class HomeController extends Controller
{

/**
 * Search for cities, regions and countries
 *
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 */
public function search(Request $request)
{
    $term = $request->q;

    $citySuggestions = City::where('name', 'like', '%' . $term . '%')->get();
    $regionSuggestions = Region::where('name', 'like', '%' . $term . '%')->get();
    $countrySuggestions = Country::where('name', 'like', '%' . $term . '%')->get();

    $suggestions = collect()
    ->merge($citySuggestions->map(fn ($city) => ['value' => $city->name, 'type' => 'city']))
    ->merge($regionSuggestions->map(fn ($region) => ['value' => $region->name, 'type' => 'region']))
    ->merge($countrySuggestions->map(fn ($country) => ['value' => $country->name, 'type' => 'country']))
    ->values() // Remove potential duplicates
    ->unique('value');

        return response()->json([
            'suggestions' => $suggestions
        ]);
}

    
}
