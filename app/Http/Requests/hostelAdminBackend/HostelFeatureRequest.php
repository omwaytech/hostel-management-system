<?php

namespace App\Http\Requests\hostelAdminBackend;

use Illuminate\Foundation\Http\FormRequest;

class HostelFeatureRequest extends FormRequest
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
                'feature.*.feature_name' => 'required|string|max:150|regex:/^[a-zA-Z0-9\s,\'\.\-\(\)]+$/',
                'feature.*.feature_icon' => 'required',
            ];
        };

         if($this->isMethod('put')){
            $rules = [
                'feature_name' => 'required|string|max:150|regex:/^[a-zA-Z0-9\s,\'\.\-\(\)]+$/',
                'feature_icon' => 'nullable',
            ];
        };

        return $rules;
    }
}
