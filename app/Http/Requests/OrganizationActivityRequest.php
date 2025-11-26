<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationActivityRequest extends FormRequest
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
            'lastMeetingDate' => 'required|date',
            'totalMembersLastMeeting' => 'required|integer',
            'objectives' => 'nullable|string',
            'planning' => 'nullable|string',
            'members_opinion_doc' => 'nullable|string',
            'objectives_doc' => 'nullable|string',
            'planning_doc' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'lastMeetingDate.required' => 'The last meeting date is required.',
            'lastMeetingDate.date' => 'The last meeting date must be a valid date.',
            'totalMembersLastMeeting.required' => 'The total members last meeting is required.',
            'totalMembersLastMeeting.integer' => 'The total members last meeting must be an integer.',
        ];
    }
}