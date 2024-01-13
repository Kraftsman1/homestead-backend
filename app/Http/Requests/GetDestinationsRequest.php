<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetDestinationsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'city_id' => 'nullable|numeric|exists:cities,id',
            'region_id' => 'nullable|numeric|exists:regions,id',
            'country_id' => 'nullable|numeric|exists:countries,id',
            'per_page' => 'nullable|numeric|min:1|max:100',
            'page' => 'nullable|numeric|min:1',
        ];
    }
}
