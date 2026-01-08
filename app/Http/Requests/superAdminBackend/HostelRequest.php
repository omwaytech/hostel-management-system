<?php

namespace App\Http\Requests\superAdminBackend;

use Illuminate\Foundation\Http\FormRequest;

class HostelRequest extends FormRequest
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
                'name' => 'required|string|max:70|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
                'logo' => 'required|file|mimes:jpeg,png,jpg,gif|max:1000',
                'description' => 'required|string',
                'contact' => 'required|digits:10',
                'location' => 'required|string|max:100|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
                'latitude' => 'required|string',
                'longitude' => 'required|string',
                'email' => 'required|email:rfc,dns|max:65',
            ];
        }
        if($this->isMethod('put')){
            $rules = [
                'name' => 'required|string|max:70|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
                'logo' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:1000',
                'description' => 'required|string',
                'contact' => 'required|digits:10',
                'location' => 'required|string|max:100',
                'latitude' => 'required|string',
                'longitude' => 'required|string',
                'email' => 'required|email:rfc,dns|max:65',
            ];
        }
        return $rules;
    }

    // public function messages()
    // {
    //     return [
    //         'name.required' => 'Hostel name is required',
    //         'logo' => 'Hostel logo is required',
    //         'description' => 'Hostel description is required',
    //         'contact' => 'Hostel contact is required',
    //         'location' => 'Hostel location is required',
    //         'email' => 'Hostel email is required',
    //     ];
    // }
}
