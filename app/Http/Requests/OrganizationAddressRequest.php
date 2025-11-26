<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationAddressRequest extends FormRequest
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
            'division_id' => 'required|integer',
            'district_id' => 'required|integer',
            'upazila_id' => 'required|integer',
            'post_office_bn' => ['required', 'string', 'max:255', 'regex:/^[\p{Bengali}0-9৳\s\p{P}]+$/u'],
            'post_office_en' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s\p{P}\p{S}]+$/u'],
            'street_bn' => ['required', 'string', 'max:255', 'regex:/^[\p{Bengali}0-9৳\s\p{P}]+$/u'],
            'street_en' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s\p{P}\p{S}]+$/u'],
            'address_bn' => ['required', 'string', 'max:255', 'regex:/^[\p{Bengali}0-9৳\s\p{P}]+$/u'],
            'address_en' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s\p{P}\p{S}]+$/u'],
            'phone' => ['required', 'regex:/^[0-9]{11}$/'],
            'email' => 'required|email',
            'website' => 'nullable',
            'facebook' => 'nullable',
            'linkedin' => 'nullable',
            'twitter' => 'nullable',
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
            'post_office_bn.regex' => 'The post office name in Bangla must contain only Bengali characters, numbers, and symbols.',
            'post_office_en.regex' => 'The post office name in English must contain only English letters, numbers, and symbols.',
            'street_bn.regex' => 'The street name in Bangla must contain only Bengali characters, numbers, and symbols.',
            'street_en.regex' => 'The street name in English must contain only English letters, numbers, and symbols.',
            'address_bn.regex' => 'The address in Bangla must contain only Bengali characters, numbers, and symbols.',
            'address_en.regex' => 'The address in English must contain only English letters, numbers, and symbols.',
            'phone.regex' => 'The phone number must be exactly 11 digits.',
            'email.email' => 'The email must be a valid email address.',
        ];
    }
}
