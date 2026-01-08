<?php

namespace App\Http\Requests\hostelAdminBackend;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
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
            'about_title' => 'required|string|max:150|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
            'about_description' => 'required|string',
            'google_map_embed' => 'required|string',
            'contact_phone_1' => 'required|string',
            'contact_phone_2' => 'required|string',
            'physical_address' => 'required|string|max:150|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
            'social_whatsapp' => 'required',
            'social_facebook' =>'required',
            'social_instagram' => 'required',
            'footer_description' => 'required|string',
            'navbar_logo' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:1000',
            'footer_logo' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:1000',
        ];
    }
}
