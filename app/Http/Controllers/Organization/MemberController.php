<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationMemberRequest;
use App\Models\Organization;
use App\Models\OrganizationMember;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    // Organization members form
    public function create()
    {
        $user_id = Auth::id();
        $check_president_id = OrganizationMember::where('user_id', $user_id)->where('designation', 'president')->first();
        $check_secretary_id = OrganizationMember::where('user_id', $user_id)->where('designation', 'secretary')->first();
        return view('organization.org_reg_forms.members_details', compact('check_president_id', 'check_secretary_id'));
    }

    // Store or update organization members
    public function store(OrganizationMemberRequest $request)
    {
        try {
            $user_id = Auth::id();
            $organization = Organization::where('user_id', $user_id)->first();
            $data = $request->validated(); // Get validated data from the request

            // Check if phone numbers already exist
            $check_phone_no = OrganizationMember::where('user_id', '!=', $user_id)
                ->where('organization_id', '!=', $organization->id)
                ->where(function ($query) use ($request) {
                    $query->where('phone', $request->presidentPhone)
                        ->orWhere('phone', $request->secretaryPhone);
                })
                ->exists();

            if ($check_phone_no) {
                session()->flash('error', translate('Phone number already Exists!'));
                return redirect()->back()->withInput();
            }

            // Array of members to update or create
            $members = [
                [
                    'designation' => 'president',
                    'name_bn' => $request->presidentNameBangla,
                    'name_en' => $request->presidentNameEnglish,
                    'dob' => $request->presidentDOB,
                    'phone' => $request->presidentPhone,
                    'email' => $request->presidentEmail,
                    'nid' => $request->presidentNID,
                    'image' => $request->presidentImage,
                ],
                [
                    'designation' => 'secretary',
                    'name_bn' => $request->secretaryNameBangla,
                    'name_en' => $request->secretaryNameEnglish,
                    'dob' => $request->secretaryDOB,
                    'phone' => $request->secretaryPhone,
                    'email' => $request->secretaryEmail,
                    'nid' => $request->secretaryNID,
                    'image' => $request->secretaryImage,
                ]
            ];

            foreach ($members as $memberData) {
                OrganizationMember::updateOrCreate(
                    [
                        'user_id' => $user_id,
                        'organization_id' => $organization->id,
                        'designation' => $memberData['designation']
                    ],
                    [
                        'is_founder' => '0',
                        'name_bn' => $memberData['name_bn'],
                        'name_en' => $memberData['name_en'],
                        'dob' => $memberData['dob'],
                        'address' => 'n/a',
                        'age' => now()->diffInYears($memberData['dob']),
                        'nid' => $memberData['nid'],
                        'phone' => $memberData['phone'],
                        'email' => $memberData['email'],
                        'image' => $memberData['image'],
                    ]
                );
            }

            flash(translate('Leaders Details saved successfully!'))->success();
            if($organization->status == 2) {
                return redirect()->route('organization.dashboard');
            } else {
                return redirect()->route('organization.banks.create');
            }
        } catch (\Exception $e) {
            // Log the error and flash an error message
            logger()->error('Error saving organization members: ' . $e->getMessage());
            flash(translate('An error occurred while saving organization members.'))->error();
            return redirect()->back();
        }
    }
}