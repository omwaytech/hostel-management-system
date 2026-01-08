<?php

namespace App\Http\Requests\hostelAdminBackend;

use Illuminate\Foundation\Http\FormRequest;

class ResidentStoreRequest extends FormRequest
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
            'block_id' => 'required|exists:blocks,id',
            'bed_id' => 'required|exists:beds,id',
            'occupancy_id' => 'required|exists:occupancies,id',
            'full_name' => 'required|string|max:70|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
            'contact_number' => 'required|digits:10',
            'guardian_contact' => 'required|digits:10',
            'photo' => 'required|file|mimes:jpeg,png,jpg,gif|max:1000',
            'citizenship' => 'required|file|mimes:jpeg,png,jpg,gif|max:1000',
        ];
    }
    public function messages()
    {
        return [
            'block_id.required' => 'Block is required',
            'bed_id.required' => 'Bed is required',
            'occupancy_id.required' => 'Occupancy is required',
        ];
    }
}
