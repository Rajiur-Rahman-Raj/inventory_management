<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesCenterStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:500'],
            'code' => ['required', 'string', 'min:1', 'max:100'],
            'owner_name' => ['required', 'string', 'min:3', 'max:50'],
            'email' => ['required'],
            'phone' => ['required', 'min:1', 'max:100'],
            'password' => ['required', 'min:3'],
            'national_id' => ['nullable'],
            'trade_id' => ['nullable'],
            'division_id' => ['required', 'exists:divisions,id'],
            'district_id' => ['required', 'exists:districts,id'],
            'upazila_id' => ['nullable'],
            'union_id' => ['nullable'],
            'address' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field must be required.',
            'name.string' => 'The name must be a string.',
            'name.min' => 'The name must be at least :min characters.',
            'name.max' => 'The name may not be greater than :max characters.',
            'division_id.exists' => 'The selected division is invalid.',
            'district_id.exists' => 'The selected district is invalid.',
            'address.required' => 'The address field is required.',
            'address.min' => 'The address must be at least :min characters.',
            'address.max' => 'The address may not be greater than :max characters.',
        ];
    }
}
