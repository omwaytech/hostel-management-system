<?php

namespace App\Http\Requests\mainPortalFrontend;

use Illuminate\Foundation\Http\FormRequest;

class PropertyListRequest extends FormRequest
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
        return [
            'hostel_name' => 'required|string|max:255|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
            'owner_name' => 'required|string|max:255|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
            'hostel_email' => 'required|email|max:255',
            'hostel_contact' => 'required|string|max:20',
            'hostel_city' => 'required|string|max:100|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
            'hostel_location' => 'required|string|max:255|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
        ];
    }
}
