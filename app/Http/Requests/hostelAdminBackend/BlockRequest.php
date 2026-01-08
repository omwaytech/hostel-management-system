<?php

namespace App\Http\Requests\hostelAdminBackend;

use Illuminate\Foundation\Http\FormRequest;

class BlockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if($this->isMethod('post')){
            $rules = [
                //
                'block_number' => 'required|integer|min:1',
                'name' => 'required|string|max:70|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
                'photo' => 'required|file|mimes:jpeg,png,jpg,gif|max:1000',
                'description' => 'required|string',
                'contact' => 'required|digits:10',
                'location' => 'required|string|max:100|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
                'no_of_floor' => 'required|integer|min:1',
                'email' => 'required|email:rfc,dns|max:65',
                'map' => 'nullable',
                //
                'floor.*.floor_number' => 'required|integer|min:1',
                'floor.*.floor_label' => 'required|string|max:70|regex:/^[\a-zA-Z\s,\-\'\.\(\)]+$/u',
                //
                'occupancy.*.occupancy_type' => 'required|string|max:70|regex:/^[\a-zA-Z\s,\-\'\.\(\)]+$/u',
                'occupancy.*.monthly_rent' => 'required|integer|min:1',
                //
                'meals' => 'required|array',
                'meals.*.early_morning' => 'required|max:70|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
                'meals.*.morning' => 'required|max:70|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
                'meals.*.day_meal' => 'required|max:70|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
                'meals.*.evening' => 'required|max:70|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
            ];
        }
        if($this->isMethod('put')){
            $rules = [
                //
                'block_number' => 'required|integer|min:1',
                'name' => 'required|string|max:70|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
                'photo' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:1000',
                'description' => 'required|string',
                'contact' => 'required|digits:10',
                'location' => 'required|string|max:100|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
                'no_of_floor' => 'required|integer|min:1',
                'email' => 'required|email:rfc,dns|max:65',
                'map' => 'nullable',
                //
                'floor.*.floor_number' => 'required|integer|min:1',
                'floor.*.floor_label' => 'required|string|max:70|regex:/^[\a-zA-Z\s,\-\'\.\(\)]+$/u',
                //
                'occupancy.*.occupancy_type' => 'required|string|max:70|regex:/^[\a-zA-Z\s,\-\'\.\(\)]+$/u',
                'occupancy.*.monthly_rent' => 'required|integer|min:1',

                // 'meals' => 'nullable|array',
                'meals.*.early_morning' => 'nullable|max:70|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
                'meals.*.morning' => 'nullable|max:70|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
                'meals.*.day_meal' => 'nullable|max:70|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
                'meals.*.evening' => 'nullable|max:70|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'floor.*.floor_number.required' => 'Floor number is required',
            'floor.*.floor_label.required' => 'Floor label is required',
            'occupancy.*.occupancy_type' => 'Occupancy type is required',
            'occupancy.*.monthly_rent' => 'Monthly rent amount is required',
            'meals.*.early_morning' => 'Meal for early morning is required',
            'meals.*.morning' => 'Meal for morning is required',
            'meals.*.day_meal' => 'Meal for day is required',
            'meals.*.evening' => 'Meal for evening is required',
        ];
    }
}
