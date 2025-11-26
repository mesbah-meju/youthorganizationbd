<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationBankRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Allow all users to access this request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'bank_name' => 'required|array',
            'bank_name.*' => 'required|string|max:255',
            'branch_name' => 'required|array',
            'branch_name.*' => 'required|string|max:255',
            'account_name' => 'required|array',
            'account_name.*' => 'required|string|max:255',
            'account_number' => 'required|array',
            'account_number.*' => 'required|string|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'bank_name.required' => 'At least one bank name is required.',
            'bank_name.*.required' => 'Each bank name is required.',
            'branch_name.required' => 'At least one branch name is required.',
            'branch_name.*.required' => 'Each branch name is required.',
            'account_name.required' => 'At least one account holder name is required.',
            'account_name.*.required' => 'Each account holder name is required.',
            'account_number.required' => 'At least one account number is required.',
            'account_number.*.required' => 'Each account number is required.',
        ];
    }
}
