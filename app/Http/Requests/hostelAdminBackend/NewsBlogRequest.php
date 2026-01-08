<?php

namespace App\Http\Requests\hostelAdminBackend;

use Illuminate\Foundation\Http\FormRequest;

class NewsBlogRequest extends FormRequest
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
                'nb_title' => 'required|string|max:150|regex:/^[a-zA-Z0-9\s,\'\.\-\(\)]+$/',
                'nb_image' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:1024',
                'nb_badge' => 'required|string|max:150|regex:/^[a-zA-Z0-9\s,\'\.\-\(\)]+$/',
                'nb_time_to_read' => 'required|integer|min:1',
                'nb_description' => 'required|string',
                'nb_author_name' => 'required|string|max:150|regex:/^[a-zA-Z0-9\s,\'\.\-\(\)]+$/',
                'nb_author_image' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ];
        };

         if($this->isMethod('put')){
            $rules = [
                'nb_title' => 'required|string|max:150|regex:/^[a-zA-Z0-9\s,\'\.\-\(\)]+$/',
                'nb_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:1024',
                'nb_badge' => 'required|string|max:150|regex:/^[a-zA-Z0-9\s,\'\.\-\(\)]+$/',
                'nb_time_to_read' => 'required|integer|min:1',
                'nb_description' => 'required|string',
                'nb_author_name' => 'required|string|max:150|regex:/^[a-zA-Z0-9\s,\'\.\-\(\)]+$/',
                'nb_author_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ];
        };

        return $rules;
    }
}
