<?php

namespace App\Http\Requests\hostelAdminBackend;

use Illuminate\Foundation\Http\FormRequest;

class AlbumRequest extends FormRequest
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
                'album_name' => 'required|string|max:150|regex:/^[a-zA-Z0-9\s,\'\.\-\(\)]+$/',
                'album_cover' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:1024',

                'image_uploads' => 'required|array',
                'image_uploads.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:1024',
                'image_data' => 'nullable|array',
            ];
        }
        if($this->isMethod('put')){
            $rules = [
                'album_name' => 'required|string|max:150|regex:/^[a-zA-Z0-9\s,\'\.\-\(\)]+$/',
                'album_cover' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:1024',

                'image_uploads' => 'nullable|array',
                'image_uploads.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:1024',
                'image_data' => 'nullable|array',
            ];
        }
        return $rules;
    }
}
