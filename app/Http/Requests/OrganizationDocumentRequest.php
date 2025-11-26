<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationDocumentRequest extends FormRequest
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
            'reg_doc' => 'nullable|string|max:255',
            'constitution' => 'required|string|max:255',
            'general_members' => 'required|string|max:255',
            'council_members' => 'required|string|max:255',
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
            'constitution.required' => 'The constitution is required.',
            'general_members.required' => 'The general members document is required.',
            'council_members.required' => 'The council members document is required.',
        ];
    }
}
