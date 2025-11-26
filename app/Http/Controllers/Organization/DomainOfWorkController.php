<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\DomainOfWork;
use App\Models\Organization;
use App\Models\OrganizationDomain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DomainOfWorkController extends Controller
{
    // domain 
    public function create()
    {
        $user_id = Auth::id();
        $check_details = Organization::where('user_id', $user_id)->exists();
        $org_details = Organization::where('user_id', $user_id)->first();

        $domains = DomainOfWork::get();
        $org_domains = OrganizationDomain::where('user_id', $user_id)->first();
        if ($org_domains) {
            $domains_id = json_decode($org_domains->domain_id);
            $other = $org_domains->others;
        } else {
            $domains_id = [];
            $other = '';
        }
        return view('organization.org_reg_forms.domains_of_work', compact('domains', 'domains_id', 'other','check_details','org_details'));
    }

    public function store(Request $request)
    {
        $user_id = Auth::id();
        $check_for_edit = OrganizationDomain::where('user_id', $user_id)->exists();
        $organization = Organization::where('user_id', $user_id)->first();
        $request->validate([
            'org_domains' => 'array',
            'other_domain' => 'nullable|string|max:255',
        ]);

        if ($check_for_edit) {
            $org_domain = OrganizationDomain::where('user_id', $user_id)->first();

            $org_domain->user_id = $user_id;
            $org_domain->domain_id = json_encode($request->org_domains);
            $org_domain->others = $request->other_domain;
            $org_domain->save();
            flash(translate('Organization Domains updated successfully!'))->success();
        } else {
            $org_domain = new OrganizationDomain();

            $org_domain->user_id = $user_id;
            $org_domain->domain_id = json_encode($request->org_domains);
            $org_domain->others = $request->other_domain;
            $org_domain->save();
            flash(translate('Organization Domains saved successfully!'))->success();
        }
        if($organization->status == 2) {
            return redirect()->route('organization.dashboard');
        } else {
            return redirect()->route('organization.challan.create');
        }
    }
}