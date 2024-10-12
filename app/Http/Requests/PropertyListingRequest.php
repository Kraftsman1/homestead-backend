<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyListingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Allow all users to make this request
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'property_type' => 'required|string',
            'price' => 'required|numeric',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'max_guests' => 'required|integer',
            'address' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'region_id' => 'required|exists:regions,id',
            'country_id' => 'required|exists:countries,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048', 
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The property name is required.',
            'description.required' => 'The property description is required.',
            'property_type.required' => 'The property type is required.',
            'price.required' => 'The property price is required.',
            'bedrooms.required' => 'The number of bedrooms is required.',
            'bathrooms.required' => 'The number of bathrooms is required.',
            'max_guests.required' => 'The maximum number of guests is required.',
            'address.required' => 'The property address is required.',
            'city_id.required' => 'The city ID is required.',
            'region_id.required' => 'The region ID is required.',
            'country_id.required' => 'The country ID is required.',
            'latitude.required' => 'The latitude is required.',
            'longitude.required' => 'The longitude is required.',
            'images.required' => 'The property images are required.',
            'images.*.image' => 'The file must be an image.',
            'images.*.mimes' => 'The image must be a file of type: jpeg, png, jpg.',
            'images.*.max' => 'The image must not be greater than 2MB.',
        ];
    }
}
