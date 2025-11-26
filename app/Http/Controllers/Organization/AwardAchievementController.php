<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationAwardRequest;
use App\Models\Organization;
use App\Models\OrganizationAward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AwardAchievementController extends Controller
{
    // Awards and achievements form
    public function create()
    {
        $user_id = Auth::id();
        $organization_award = OrganizationAward::where('user_id', $user_id)->get();
        return view('organization.org_reg_forms.award_achievement', compact('organization_award'));
    }

    // Store awards and achievements
    public function store(OrganizationAwardRequest $request)
    {
        $user_id = Auth::id();
        $organization = Organization::where('user_id', $user_id)->first();

        $validatedData = $request->validated();

        OrganizationAward::where('user_id', $user_id)->delete();
        foreach ($request->type as $index => $type) {
            OrganizationAward::create([
                'user_id' => $user_id,
                'organization_id' => $organization->id,
                'type' => $type,
                'award_tittle' => $request->award_tittle[$index],
                'from_organization' => $request->from_organization[$index],
                'recieve_date' => $request->recieve_date[$index],
                'date' => now(), // Current timestamp
            ]);
        }

        session()->flash('success', translate('Awards and Achievements saved successfully!'));
        if($organization->status == 2) {
            return redirect()->route('organization.dashboard');
        } else {
            return redirect()->route('organization.grants.create');
        }
    }
}