<?php

namespace App\Http\Requests\superAdminBackend;

use Illuminate\Foundation\Http\FormRequest;

class FAQRequest extends FormRequest
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
                'category_id' => 'required|exists:system_f_a_q_categories,id',
                'faq.*.faq_question' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s,\'\.\-\(\)&\/]+$/',
                'faq.*.faq_answer' => 'required|string',
            ];
        }
        if($this->isMethod('put')){
            $rules = [
                'category_id' => 'required|exists:system_f_a_q_categories,id',
                'faq_question' => 'required|string|max:255|regex:/^[\a-zA-Z0-9\s,\'\.\(\)]+$/u',
                'faq_answer' => 'required|string',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return[
            'faq.*.faq_question' => 'This field is required',
            'faq.*.faq_answer' => 'This field is required',
        ];
    }
}
