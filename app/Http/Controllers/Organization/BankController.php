<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationBankRequest;
use App\Models\OrganizationBank;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    // Organization bank details form
    public function create()
    {
        $user_id = Auth::id();
        $banks = OrganizationBank::where('user_id', $user_id)->get(); // Fetch all bank records
        return view('organization.org_reg_forms.bank_details', compact('banks'));
    }

    // Store or update organization bank details
    public function store(OrganizationBankRequest $request)
    {
        try {
            $user_id = Auth::id();
            $organization = Organization::where('user_id', $user_id)->first();

            // Validate the request data
            $validatedData = $request->validated();

            // Delete existing bank records for the user
            OrganizationBank::where('user_id', $user_id)->delete();
            foreach ($request->bank_name as $index => $bankName) {
                OrganizationBank::create([
                    'user_id' => $user_id,
                    'organization_id' => $organization->id,
                    'bank_name' => $bankName,
                    'branch_name' => $request->branch_name[$index],
                    'account_name' => $request->account_name[$index],
                    'account_number' => $request->account_number[$index],
                ]);
            }

            flash(translate('Finance Details saved successfully!'))->success();
            if($organization->status == 2) {
                return redirect()->route('organization.dashboard');
            } else {
                return redirect()->route('organization.activity.create');
            }
        } catch (\Exception $e) {
            // Log the error and flash an error message
            logger()->error('Error saving organization bank details: ' . $e->getMessage());
            flash(translate('An error occurred while saving finance details.'))->error();
            return redirect()->back();
        }
    }
}