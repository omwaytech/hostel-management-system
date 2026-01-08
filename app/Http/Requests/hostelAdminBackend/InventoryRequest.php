<?php

namespace App\Http\Requests\hostelAdminBackend;

use Illuminate\Foundation\Http\FormRequest;

class InventoryRequest extends FormRequest
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
                'type' => 'required',
                'bill_number' => 'required_if:type,Buy',
                //
                'item.*.item_name' => 'required|string|max:70|regex:/^[\a-zA-Z\s,\-\'\.\(\)]+$/u',
                'item.*.quantity' => 'required|integer|min:1',
                'item.*.unit_price' => 'required|integer|min:1',
            ];
        }
        if($this->isMethod('put')){
            $rules = [
                'block_id' => 'required|exists:blocks,id',
                'type' => 'required',
                'bill_number' => 'required_if:type,Buy',
                //
                'item.*.item_name' => 'required|string|max:70|regex:/^[\a-zA-Z\s,\-\'\.\(\)]+$/u',
                'item.*.quantity' => 'required|integer|min:1',
                'item.*.unit_price' => 'required|integer|min:1',
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'block_id' => 'Block is required',
            'item.*.item_name' => 'Item name is required',
            'item.*.quantity' => 'Quantity is required',
            'item.*.unit_price' => 'Price is required'
        ];
    }
}
