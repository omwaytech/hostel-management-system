<?php

namespace App\Http\Requests\hostelAdminBackend;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
                'block_id' => 'required|exists:blocks,id',
                'full_name' => 'required|string|max:70|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
                'role' => 'required|string|max:50|regex:/^[\a-zA-Z\s,\'\.\(\)]+$/u',
                'contact_number' => 'required|digits:10',
                'basic_salary' => 'required|integer|min:1',
                'photo' => 'required|file|mimes:jpeg,png,jpg,gif|max:1000',
                'citizenship' => 'required|file|mimes:jpeg,png,jpg,gif|max:1000',
                'join_date' => 'required|date',
                'pan_number' => 'required|integer|min:1',
                'bank_account_number' => 'required|integer|min:1',
                'income_tax' => 'required|integer|min:1',
                'cit' => 'nullable|integer|min:1',
                'ssf' => 'nullable|integer|min:1',
            ];
        }
        if($this->isMethod('put')){
            $rules = [
                'block_id' => 'required|exists:blocks,id',
                'full_name' => 'required|string|max:70|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
                'role' => 'required|string|max:50|regex:/^[\a-zA-Z\s,\'\.\(\)]+$/u',
                'contact_number' => 'required|digits:10',
                'basic_salary' => 'required|integer|min:1',
                'photo' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:1000',
                'citizenship' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:1000',
                'join_date' => 'required|date',
                'pan_number' => 'required|integer|min:1',
                'bank_account_number' => 'required|integer|min:1',
                'income_tax' => 'required|integer|min:1',
                'cit' => 'nullable|integer|min:1',
                'ssf' => 'nullable|integer|min:1',
            ];
        }
        return $rules;
    }
}
