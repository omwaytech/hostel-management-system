<?php

namespace App\Http\Requests\superAdminBackend;

use Illuminate\Foundation\Http\FormRequest;

class FAQCategoryRequest extends FormRequest
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
                'category_name' => 'required|string|max:70|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
            ];
        }
        if($this->isMethod('put')){
            $rules = [
                'category_name' => 'required|string|max:70|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
            ];
        }

        return $rules;
    }
}
