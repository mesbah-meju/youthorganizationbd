<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationRequest;
use App\Models\District;
use App\Models\Division;
use App\Models\DomainOfWork;
use App\Models\Organization;
use App\Models\OrganizationActivity;
use App\Models\OrganizationAddress;
use App\Models\OrganizationAward;
use App\Models\OrganizationBank;
use App\Models\OrganizationDocument;
use App\Models\OrganizationDomain;
use App\Models\OrganizationGrant;
use App\Models\OrganizationMember;
use App\Models\Upazila;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    public function create()
    {
        $user_id = Auth::id();
        $org_details = Organization::where('user_id', $user_id)->first();
        return view('organization.org_reg_forms.organization_details', compact('org_details'));
    }

    // Store or update organization details
    public function store(OrganizationRequest $request)
    {
        try {
            $user_id = Auth::id();
            $data = $request->validated();
            $data['user_id'] = $user_id;
            Organization::updateOrCreate(['user_id' => $user_id], $data);

            flash(translate('Organization saved successfully!'))->success();
            return redirect()->route('organization.address.create');
        } catch (\Exception $e) {

            logger()->error('Error saving organization: ' . $e->getMessage());
            flash(translate('An error occurred while saving organization.'))->error();
            return redirect()->back();
        }
    }

    // Submit 
    public function show()
    {
        $user_id = Auth::id();

        $districts = District::get();
        $sub_districts = Upazila::get();
        $divisions = Division::get();
        $documents = OrganizationDocument::where('user_id', $user_id)->first();
        $banks = OrganizationBank::where('user_id', $user_id)->get();
        $organization_award = OrganizationAward::where('user_id', $user_id)->get();
        $organization_grant = OrganizationGrant::where('user_id', $user_id)->get();
        $org_address = OrganizationAddress::where('user_id', $user_id)->first();
        $org_details = Organization::where('user_id', $user_id)->first();
        $organization_activity = OrganizationActivity::where('user_id', $user_id)->first();
        $check_president_id = OrganizationMember::where('user_id', $user_id)->where('designation', 'president')->first();
        $check_secretary_id = OrganizationMember::where('user_id', $user_id)->where('designation', 'secretary')->first();

        $check_english_id = OrganizationMember::where('user_id', $user_id)->where('designation', '!=', 'secretary')->where('designation', '!=', 'president')->first();

        $domains = DomainOfWork::get();
        $org_domains = OrganizationDomain::where('user_id', $user_id)->first();
        if ($org_domains) {
            $domains_id = json_decode($org_domains->domain_id);
            $other = $org_domains->others;
        } else {
            $domains_id = [];
            $other = '';
        }

        return view('organization.org_reg_forms.submit', compact('organization_activity', 'organization_award', 'organization_grant', 'org_address', 'org_details', 'districts', 'sub_districts', 'check_president_id', 'check_secretary_id', 'check_english_id', 'banks', 'divisions', 'documents', 'domains', 'domains_id', 'other'));
    }

    public function submit_for_verification()
    {
        $user = Auth::user();

        if (Organization::where('user_id', $user->id)->exists()) {
            $organization = Organization::where('user_id', $user->id)->first();
        } else {
            $organization = new Organization();
            $organization->user_id = $user->id;
            $organization->name = $user->name;
            $organization->email = $user->email;
            $organization->phone = $user->phone;
            $organization->status = 0;  // 0 = pending, 1 = approved, 2 = rejected
            $organization->save();
        }

        $organization = Organization::where('user_id', $user->id)->first();
        $organization->submitted_at = date('Y-m-d H:i:s');
        $organization->submitted_by = Auth::user()->id;
        $organization->status = 1;
        $organization->save();

        flash(translate('Organization submitted for verification successfully!'))->success();
        return redirect()->route('organization.dashboard');
    }
}