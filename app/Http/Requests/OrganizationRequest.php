<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
{
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
            'work_area' => 'required|string',
            'org_name_bn' => ['required', 'string', 'max:255', 'regex:/^[\p{Bengali}0-9৳\s\p{P}]+$/u'],
            'org_name_en' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s\p{P}\p{S}]+$/u'],
            'org_type' => 'required|string',
            'old_reg_type' => 'nullable|string',
            'reg_no' => 'nullable|string',
            'established_date' => 'required|date',
            'logo' => 'nullable|string',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'org_name_bn.regex' => 'The organization name in Bangla must contain only Bengali characters, numbers, and symbols.',
            'org_name_en.regex' => 'The organization name in English must contain only English letters, numbers, and symbols.',
        ];
    }
}
