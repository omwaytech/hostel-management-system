<?php

namespace App\Http\Requests\hostelAdminBackend;

use Illuminate\Foundation\Http\FormRequest;

class HostelAmenityRequest extends FormRequest
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
                'amenity.*.amenity_name' => 'required|string|max:150|regex:/^[a-zA-Z0-9\s,\'\.\-\(\)]+$/',
                'amenity.*.amenity_icon' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ];
        };

         if($this->isMethod('put')){
            $rules = [
                'amenity_name' => 'required|string|max:150|regex:/^[a-zA-Z0-9\s,\'\.\-\(\)]+$/',
                'amenity_icon' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ];
        };

        return $rules;
    }
}
