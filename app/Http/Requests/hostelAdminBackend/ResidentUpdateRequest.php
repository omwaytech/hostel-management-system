<?php

namespace App\Http\Requests\hostelAdminBackend;

use Illuminate\Foundation\Http\FormRequest;

class ResidentUpdateRequest extends FormRequest
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
            'full_name' => 'required|string|max:70|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
            'contact_number' => 'required|digits:10',
            'guardian_contact' => 'required|digits:10',
            'photo' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:1000',
            'citizenship' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:1000',
        ];
    }
}
