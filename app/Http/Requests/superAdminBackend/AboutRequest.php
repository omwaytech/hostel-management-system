<?php

namespace App\Http\Requests\superAdminBackend;

use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
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
                'about_title' => 'required|string|max:70|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
                'about_description' => 'required|string',
                'about_mission' => 'required|string',
                'about_vision' => 'required|string',

                'value.*.value_title' => 'required|string|max:150|regex:/^[a-zA-Z0-9\s,\'\.\-\(\)&\/]+$/',
                'value.*.value_description' => 'required|string',
                'value.*.value_icon' => 'required|file|mimes:jpeg,png,jpg,gif|max:1000'
            ];
        }
        if($this->isMethod('put')){
            $rules = [
                'about_title' => 'required|string|max:70|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
                'about_description' => 'required|string',
                'about_mission' => 'required|string',
                'about_vision' => 'required|string',

                'value.*.value_title' => 'nullable|string|max:150|regex:/^[a-zA-Z0-9\s,\'\.\-\(\)&\/]+$/',
                'value.*.value_description' => 'nullable|string',
                'value.*.value_icon' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:1000'
            ];
        }

        return $rules;
    }

    // public function messages()
    // {
    //     return [
    //         'value.*.value_icon' => 'This field is required',
    //         'value.*.value_title' => 'This field is required',
    //         'value.*.value_description' => 'This field is required',
    //     ];
    // }
}
