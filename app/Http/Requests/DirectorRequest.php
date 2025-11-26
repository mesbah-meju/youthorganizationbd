<?php

namespace App\Http\Requests;

use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DirectorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $userId = $this->route('id');

        return [
            'name' => 'required|string|max:255',
            'email' => ['required','string','email','max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'phone' => ['required','numeric','digits:11',
                Rule::unique('users', 'phone')->ignore($userId),
            ],
            'password' => [
                !$userId ? 'required' : 'nullable', 'string', 'min:6',
            ],
            'g-recaptcha-response' => [
                Rule::when(get_setting('google_recaptcha') == 1, ['required', new Recaptcha()], ['sometimes']),
            ],
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already in use.',
            'phone.required' => 'The phone number is required.',
            'phone.digits' => 'The phone number must be exactly 11 digits.',
            'phone.unique' => 'This phone number is already in use.',
            'password.min' => 'The password must be at least 6 characters long.',
            'g-recaptcha-response.required' => 'Please complete the Google reCAPTCHA verification.',
        ];
    }
}
