<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationGrantRequest;
use App\Models\Organization;
use App\Models\OrganizationGrant;
use Illuminate\Support\Facades\Auth;

class GrantsAidsController extends Controller
{
    // Awards and achievements form
    public function create()
    {
        $user_id = Auth::id();
        $organization_grant = OrganizationGrant::where('user_id', $user_id)->get();
        return view('organization.org_reg_forms.grants_aids', compact('organization_grant'));
    }

    // Store awards and achievements
    public function store(OrganizationGrantRequest $request)
    {
        $user_id = Auth::id();
        $organization = Organization::where('user_id', $user_id)->first();

        $validatedData = $request->validated();

        // Delete existing records for the user
        OrganizationGrant::where('user_id', $user_id)->delete();

        // Ensure grant_details is an array from the request
        foreach ($validatedData['grant_detail'] as $index => $grant_detail) {
            OrganizationGrant::create([
                'user_id' => $user_id,
                'organization_id' => $organization->id,
                'grant_detail' => $grant_detail,
                'from_organization' => $validatedData['from_organization'][$index],
                'recieve_date' => $validatedData['recieve_date'][$index],
                'date' => now(),
            ]);
        }


        session()->flash('success', translate('Grants and Aids saved successfully!'));
        if ($organization->status == 2) {
            return redirect()->route('organization.dashboard');
        } else {
            return redirect()->route('organization.domains.create');
        }
    }
}