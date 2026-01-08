<?php

namespace App\Http\Requests\hostelAdminBackend;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
                //
                'floor_id' => 'required|exists:floors,id',
                'room_number' => 'required|integer|min:1',
                'photo' => 'required|file|mimes:jpeg,png,jpg,gif|max:1000',
                //
                'bed.*.bed_number' => 'required|integer|min:1',
                'bed.*.status' => 'required',
                'bed.*.photo' => 'required|file|mimes:jpeg,png,jpg,gif|max:1000',
            ];
        }
        if($this->isMethod('put')){
            $rules = [
                //
                'floor_id' => 'required|exists:floors,id',
                'room_number' => 'required|integer|min:1',
                'photo' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:1000',
                //
                'bed.*.bed_number' => 'required|integer|min:1',
                'bed.*.status' => 'required',
                'bed.*.photo' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:1000',
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'bed.*.bed_number.required' => 'Bed number is required',
            'bed.*.status.required' => 'Bed status is required',
            'bed.*.photo' => 'Bed photo is required',
        ];
    }
}
