<?php

namespace App\Http\Requests\hostelPortalFrontend;

use Illuminate\Foundation\Http\FormRequest;

class InquiryRequest extends FormRequest
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
            'hostel_id' => 'required|exists:hostels,id',
            'full_name' => 'required|string|max:150|regex:/^[a-zA-Z0-9\s,\'\.\-\(\)]+$/',
            'email_address' => 'required|email|max:150',
            'subject' => 'required|string|max:255',
            'meal_radio' => 'required',
            'message' => 'required|string',
        ];
    }
}
