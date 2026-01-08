<?php

namespace App\Http\Requests\hostelAdminBackend;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                'photo' => 'required|file|mimes:jpeg,png,jpg,gif|max:1000',
                'citizenship' => 'required|file|mimes:jpeg,png,jpg,gif|max:1000',
                'contact_number' => 'required|digits:10',
                'date_of_birth' => 'required|date|before_or_equal:today',
                'gender' => 'required',
                'permanent_address' => 'required|string|max:100|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
                'email' => 'required|email:rfc,dns|max:65',
                'password' => 'required|string|min:8|regex:/[a-z,A-Z,0-9]/|regex:/[@$!%*#?&]/',
                'role_id' => 'required',
            ];
        }
        return $rules;
    }
}
