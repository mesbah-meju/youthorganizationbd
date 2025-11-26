<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationActivityRequest;
use App\Models\Organization;
use App\Models\OrganizationActivity;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    // Organization activity details form
    public function create()
    {
        $user_id = Auth::id();
        $organization_activity = OrganizationActivity::where('user_id', $user_id)->first();
        return view('organization.org_reg_forms.activity_details', compact('organization_activity'));
    }

    // Store or update organization activity details
    public function store(OrganizationActivityRequest $request)
    {
        try {
            $user_id = Auth::id();
            $check_details = Organization::where('user_id', $user_id)->exists();
            $organization = Organization::where('user_id', $user_id)->first();
            
            $data = $request->validated();

            OrganizationActivity::updateOrCreate(
                ['user_id' => $user_id],
                [
                    'last_meeting_date' => $data['lastMeetingDate'],
                    'total_members_last_meeting' => $data['totalMembersLastMeeting'],
                    'members_opinion_doc' => $request->members_opinion_doc ?? null,
                    'objectives' => $data['objectives'],
                    'objectives_doc' => $request->objectives_doc ?? null,
                    'plan' => $data['planning'],
                    'plan_doc' => $request->planning_doc ?? null,
                ]
            );

            flash(translate('Activity Details saved successfully!'))->success();
            if($check_details && $organization->reg_type == 'registered') {
                if($organization->status == 2) {
                    return redirect()->route('organization.dashboard');
                } else {
                    return redirect()->route('organization.awards.create');
                }
            } else {
                if($organization->status == 2) {
                    return redirect()->route('organization.dashboard');
                } else {
                    return redirect()->route('organization.domains.create');
                }
            }
        } catch (\Exception $e) {
            logger()->error('Error saving organization activity details: ' . $e->getMessage());
            flash(translate('An error occurred while saving activity details.'))->error();
            return redirect()->back();
        }
    }
}