<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrganizationProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        $newPasswordRule = ['sometimes'];
        $confirmPasswordRule = ['sometimes'];

        if ($this->request->get('new_password') !== null || $this->request->get('confirm_password') !== null) {
            $newPasswordRule = ['required', 'min:6'];
            $confirmPasswordRule = ['required', 'same:new_password'];
        }

        return [
            'name'              => ['required', 'max:191'],
            'email'             => [
                'required',
                'email',
                'max:191',
                Rule::unique('users', 'email')->ignore($this->user()->id),
            ],
            'phone'             => ['required', 'numeric', 'digits:11'],
            'new_password'      => $newPasswordRule,
            'confirm_password'  => $confirmPasswordRule,
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages()
    {
        return [
            'name.required'         => translate('Name is required'),
            'email.required'        => translate('Email is required'),
            'email.email'           => translate('Enter a valid email address'),
            'email.unique'          => translate('Email is already in use'),
            'phone.required'        => translate('Phone number is required'),
            'phone.numeric'         => translate('Phone number must be numeric'),
            'phone.digits'          => translate('Phone number must be exactly 11 digits'),
            'new_password.min'      => translate('Minimum 6 characters'),
            'confirm_password.min'  => translate('Minimum 6 characters'),
        ];
    }
}
