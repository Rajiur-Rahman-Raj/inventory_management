<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyStoreRequest extends FormRequest
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
            'email' => ['required', 'string', 'min:5', 'max:100'],
            'phone' => ['required', 'string', 'min:3', 'max:50'],
            'trade_id' => ['nullable'],
            'address' => ['required', 'min:1', 'max:1000'],
            'logo' => ['required', 'mimes:jpg,jpeg,png'],
        ];
    }
}
