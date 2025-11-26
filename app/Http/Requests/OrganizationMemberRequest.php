<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationMemberRequest extends FormRequest
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
            'presidentNameBangla' => ['required', 'string', 'max:255', 'regex:/^[\p{Bengali}0-9৳\s\p{P}]+$/u'],
            'presidentNameEnglish' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s\p{P}\p{S}]+$/u'],
            'presidentDOB' => 'required|date',
            'presidentPhone' => [
                'required',
                'regex:/^[0-9]{11}$/',
                function ($attribute, $value, $fail) {
                    if ($value === $this->input('secretaryPhone')) {
                        $fail('The president\'s phone number cannot be the same as the secretary\'s phone number.');
                    }
                },
            ],
            'presidentEmail' => 'required|email|max:255',
            'presidentNID' => 'required|string|max:50',

            'secretaryNameBangla' => ['required', 'string', 'max:255', 'regex:/^[\p{Bengali}0-9৳\s\p{P}]+$/u'],
            'secretaryNameEnglish' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s\p{P}\p{S}]+$/u'],
            'secretaryDOB' => 'required|date',
            'secretaryPhone' => [
                'required',
                'regex:/^[0-9]{11}$/',
                function ($attribute, $value, $fail) {
                    if ($value === $this->input('presidentPhone')) {
                        $fail('The secretary\'s phone number cannot be the same as the president\'s phone number.');
                    }
                },
            ],
            'secretaryEmail' => 'required|email|max:255',
            'secretaryNID' => 'required|string|max:50',
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
            'presidentNameBangla.regex' => 'The president name in Bangla must contain only Bengali characters, numbers, and symbols.',
            'presidentNameEnglish.regex' => 'The president name in English must contain only English letters, numbers, and symbols.',
            'secretaryNameBangla.regex' => 'The secretary name in Bangla must contain only Bengali characters, numbers, and symbols.',
            'secretaryNameEnglish.regex' => 'The secretary name in English must contain only English letters, numbers, and symbols.',
            'presidentPhone.regex' => 'The president phone number must be exactly 11 digits.',
            'secretaryPhone.regex' => 'The secretary phone number must be exactly 11 digits.',
            'presidentEmail.email' => 'The president email must be a valid email address.',
            'secretaryEmail.email' => 'The secretary email must be a valid email address.',
        ];
    }
}
