<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationChallanRequest; // Custom Form Request
use App\Models\Organization;
use App\Models\OrganizationDocument;
use Illuminate\Support\Facades\Auth;

class ChallanController extends Controller
{
    // Challan form
    public function create()
    {
        $user_id = Auth::id();
        $documents = OrganizationDocument::where('user_id', $user_id)->first();
        return view('organization.org_reg_forms.challan', compact('documents'));
    }

    // Store or update challan
    public function store(OrganizationChallanRequest $request)
    {
        try {
            $user_id = Auth::id();
            $organization_id = Organization::where('user_id', $user_id)->first()->id;
            $data = $request->validated(); // Get validated data from the request

            // Update or create organization document
            OrganizationDocument::updateOrCreate(
                ['user_id' => $user_id], // Condition to find the record
                [
                    'organization_id' => $organization_id,
                    'challan' => $data['challan'],
                ]
            );

            session()->flash('success', translate('Challan saved successfully!'));
            return redirect()->route('organization.documents.create');
        } catch (\Exception $e) {
            // Log the error and flash an error message
            logger()->error('Error saving challan: ' . $e->getMessage());
            session()->flash('error', translate('An error occurred while saving challan.'));
            return redirect()->back();
        }
    }
}