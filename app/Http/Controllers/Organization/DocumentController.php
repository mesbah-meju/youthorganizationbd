<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationDocumentRequest; // Custom Form Request
use App\Models\Organization;
use App\Models\OrganizationDocument;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    // Documents form
    public function create()
    {
        $user_id = Auth::id();
        $org_details = Organization::where('user_id', $user_id)->first();
        $documents = OrganizationDocument::where('user_id', $user_id)->first();
        return view('organization.org_reg_forms.document', compact('documents','org_details'));
    }

    // Store or update documents
    public function store(OrganizationDocumentRequest $request)
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
                    'reg_doc' => isset($data['reg_doc']) ? $data['reg_doc'] : null,
                    'constitution' => isset($data['constitution']) ? $data['constitution'] : null,
                    'general_members' => isset($data['general_members']) ? $data['general_members'] : null,
                    'council_members' => isset($data['council_members']) ? $data['council_members'] : null,
                ]
            );

            session()->flash('success', translate('Documents saved successfully!'));
            return redirect()->route('organization.dashboard');
        } catch (\Exception $e) {
            // Log the error and flash an error message
            logger()->error('Error saving documents: ' . $e->getMessage());
            session()->flash('error', translate('An error occurred while saving documents.'));
            return redirect()->back();
        }
    }
}