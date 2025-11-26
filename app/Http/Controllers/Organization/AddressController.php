<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationAddressRequest;
use App\Models\OrganizationAddress;
use App\Models\Division;
use App\Models\District;
use App\Models\Organization;
use App\Models\Upazila;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = Auth::id();
        $org_address = OrganizationAddress::where('user_id', $user_id)->first();
        $divisions = Division::where('status', 1)->orderBy('name', 'asc')->get();
        $districts = District::get();
        $sub_districts = Upazila::get();
        $org_details = Organization::where('user_id', $user_id)->first();

        return view('organization.org_reg_forms.address_details', compact('org_details','org_address', 'districts', 'sub_districts', 'divisions'));
    }

    // Store or update organization address
    public function store(OrganizationAddressRequest $request)
    {
        try {
            $user_id = Auth::id();
            $data = $request->validated();
            $organization = Organization::where('user_id', $user_id)->first();

            $data['user_id'] = $user_id;
            OrganizationAddress::updateOrCreate(['user_id' => $user_id], $data);

            flash(translate('Organization Address saved successfully!'))->success();
            if($organization->status == 2) {
                return redirect()->route('organization.dashboard');
            } else {
                return redirect()->route('organization.members.create');
            }
        } catch (\Exception $e) {
            logger()->error('Error saving organization address: ' . $e->getMessage());
            flash(translate('An error occurred while saving organization address.'))->error();
            return redirect()->back();
        }
    }
}
