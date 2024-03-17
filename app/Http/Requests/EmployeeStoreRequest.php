<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest
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
            'phone' => ['required', 'min:1', 'max:100'],
//            'email' => ['required', 'email', 'unique:employees,email'],
            'email' => ['required', 'email'],
            'national_id' => ['nullable'],
            'date_of_birth' => ['nullable'],
            'joining_date' => ['required'],
            'designation' => ['required'],
            'employee_type' => ['required'],
            'joining_salary' => ['required'],
            'current_salary' => ['required'],
            'present_address' => ['nullable'],
            'permanent_address' => ['nullable'],
            'image' => ['nullable'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field must be required.',
            'phone.required' => 'Phone number required',
            'email.required' => 'Please enter email address',
            'joining_date.required' => 'Employee joining date is required',
            'employee_type.required' => 'Please select employment type',
            'joining_salary.required' => 'Employee joining salary is required',
            'current_salary.required' => 'Employee Current salary is required',
        ];
    }
}
