<?php

namespace App\Http\Requests\hostelAdminBackend;

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
                'about_title' => 'required|string|max:150|regex:/^[a-zA-Z0-9\s,\'\.\-\(\)]+$/',
                'about_description' => 'required|string',
                'about_mission' => 'required|string',
                'about_vision' => 'required|string',
                'about_value' => 'required|string',

                // 'page_title' => 'required|string|max:150|regex:/^[a-zA-Z0-9\s,\'\.\-\(\)]+$/',
                // 'meta_tags' => 'nullable|array|min:1',
                // 'meta_tags.*' => 'nullable|string|max:70|regex:/^[a-zA-Z0-9\s,\'\.\-\(\)]+$/',
                // 'meta_description' => 'nullable|string|max:255',
            ];
        };

        if($this->isMethod('put')){
            $rules = [
                'about_title' => 'required|string|max:150|regex:/^[a-zA-Z0-9\s,\'\.\-\(\)]+$/',
                'about_description' => 'required|string',
                'about_mission' => 'required|string',
                'about_vision' => 'required|string',
                'about_value' => 'required|string',
            ];
        };

        return $rules;
    }
}
