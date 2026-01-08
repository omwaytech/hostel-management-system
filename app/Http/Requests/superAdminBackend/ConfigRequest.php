<?php

namespace App\Http\Requests\superAdminBackend;

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
            'banner_title' => 'nullable|string|max:150|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
            'banner_subtitle' => 'nullable|string|max:250|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
            'hostel_listed' => 'nullable|string',
            'happy_customers' => 'nullable|string',
            'trusted_owners' => 'nullable|string',
            'background_title' => 'nullable|string|max:150|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
            'background_description' => 'nullable|string',
            'active_monthly_users' => 'nullable|string',
            'contact_phone' => 'nullable|string',
            'email_address' => 'nullable|email|string',
            'physical_address' => 'nullable|string|max:150|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
            'social_facebook' => 'nullable|string',
            'social_whatsapp' => 'nullable|string',
            'footer_description' => 'nullable|string',
            'navbar_logo' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:1000',
            'footer_logo' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:1000',
            'banner_image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:1000',
            'background_image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:1000',
            'about_image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:1000',
        ];
    }
}
