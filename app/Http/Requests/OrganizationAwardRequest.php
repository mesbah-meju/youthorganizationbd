<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationAwardRequest extends FormRequest
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
            'type' => 'required|array',
            'type.*' => 'required|string|in:award,achievement',
            'award_tittle' => 'required|array',
            'award_tittle.*' => 'required|string|max:255',
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
            'type.required' => 'At least one type is required.',
            'type.*.required' => 'Each type is required.',
            'award_tittle.required' => 'At least one award tittle is required.',
            'award_tittle.*.required' => 'Each award tittle is required.',
            'from_organization.required' => 'At least one from rganization is required.',
            'from_organization.*.required' => 'Each from organization is required.',
            'recieve_date.required' => 'At least recieve date is required.',
            'recieve_date.*.required' => 'Each recieve date is required.',
        ];
    }
}
