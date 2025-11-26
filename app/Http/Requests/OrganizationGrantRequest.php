<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationGrantRequest extends FormRequest
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
            'grant_detail' => 'required|array',
            'grant_detail.*' => 'required|string|max:255',
            'from_organization' => 'required|array',
            'from_organization.*' => 'required|string|max:255',
            'recieve_date' => 'required|array',
            'recieve_date.*' => 'required|date',
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
            'grant_detail.required' => 'At least one award tittle is required.',
            'grant_detail.*.required' => 'Each award tittle is required.',
            'from_organization.required' => 'At least one from rganization is required.',
            'from_organization.*.required' => 'Each from organization is required.',
            'recieve_date.required' => 'At least recieve date is required.',
            'recieve_date.*.required' => 'Each recieve date is required.',
        ];
    }
}
