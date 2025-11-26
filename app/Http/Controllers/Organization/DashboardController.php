<?php

namespace App\Http\Controllers\Organization;

use App\Models\Organization;
use App\Models\OrganizationActivity;
use App\Models\OrganizationAddress;
use App\Models\OrganizationAward;
use App\Models\OrganizationBank;
use App\Models\OrganizationDocument;
use App\Models\OrganizationDomain;
use App\Models\OrganizationGrant;
use App\Models\OrganizationMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $check_user_id = Organization::where('user_id', $user_id)->exists();
        $check_details = Organization::where('user_id', $user_id)->exists();
        $org_details = Organization::where('user_id', $user_id)->first();
        $check_address = OrganizationAddress::where('user_id', $user_id)->exists();
        $check_member = OrganizationMember::where('user_id', $user_id)->exists();
        $check_bank = OrganizationBank::where('user_id', $user_id)->exists();
        $check_social = OrganizationActivity::where('user_id', $user_id)->exists();

        $documents = OrganizationDocument::where('user_id', $user_id)->first();
        $check_challan = $documents ? $documents->challan : false;
        $check_docs = ($documents ? $documents->constitution : false) && ($documents ? $documents->general_members : false) && ($documents ? $documents->council_members : false);

        $check_domain = OrganizationDomain::where('user_id', $user_id)->exists();
        $check_award = OrganizationAward::where('user_id', $user_id)->exists();
        $check_grant = OrganizationGrant::where('user_id', $user_id)->exists();


        // return view('organization.check_dashboard');

        if ($check_details && $org_details->reg_type == null) {
            return view('organization.check_dashboard');
        } else {
            return view('organization.dashboard', compact('check_user_id', 'check_details', 'org_details', 'check_address', 'check_member', 'check_bank', 'check_social', 'check_challan', 'check_docs', 'check_domain', 'check_award', 'check_grant'));
        }
    }

    public function process(Request $request)
    {
        $request->validate([
            'reg_type' => 'required|in:new,registered',
        ]);

        $user_id = Auth::id();
        $org_details = Organization::where('user_id', $user_id)->first();
        $org_details->reg_type = $request->reg_type;
        $org_details->save();

        return redirect()->route('organization.dashboard');

    }
    public function change_status(Request $request)
    {
        $user_id = Auth::id();
        $organization = Organization::where('user_id', $user_id)->first();
        if ($organization->status == '0' || $organization->status == '3') {
            return view('organization.check_dashboard');
        } else {
            flash(translate('You can\'t change registration type while submission is pending or approved.'))->error();
            return redirect()->back();
        }
    }
}
