<?php

namespace App\Http\Controllers\Organization;

use App\Models\District;
use App\Models\Division;
use App\Models\DomainOfWork;
use App\Models\Organization;
use App\Models\OrganizationActivity;
use App\Models\OrganizationAddress;
use App\Models\OrganizationBank;
use Illuminate\Http\Request;
use App\Models\OrganizationDetails;
use App\Models\OrganizationDocument;
use App\Models\OrganizationDomain;
use App\Models\OrganizationMembers;
use App\Models\Upazila;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    //Organization details 
    public function create_org_details()
    {
        $user_id = Auth::id();
        $org_details = OrganizationDetails::where('user_id', $user_id)->first();
        return view('organization.org_reg_forms.organization_details', compact('org_details'));
    }

    public function store_org_details(Request $request)
    {
        $user_id = Auth::id();
        $check_user_id = OrganizationDetails::where('user_id', $user_id)->exists();

        if ($check_user_id) {

            $validatedData = $request->validate([
                // 'reg_type' => 'required|string',
                'work_area' => 'required|string',
                'organizationNameBangla' => ['required', 'string', 'max:255', 'regex:/^[\p{Bengali}0-9৳\s\p{P}]+$/u'],
                'organizationNameEnglish' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s\p{P}\p{S}]+$/u'],
                'org_type' => 'required|string',
                'establishment_date' => 'required|date',
            ]);

            $organizationDetails = OrganizationDetails::where('user_id', $user_id)->first();

            $organizationDetails->user_id = $user_id;
            // $organizationDetails->reg_type = $request->input('reg_type');
            $organizationDetails->work_area = $request->input('work_area');
            $organizationDetails->org_name_bn = $request->input('organizationNameBangla');
            $organizationDetails->org_name_en = $request->input('organizationNameEnglish');
            $organizationDetails->org_type = $request->input('org_type');
            $organizationDetails->establishment_date = $request->input('establishment_date');
            $organizationDetails->logo = $request->input('organization_logo');

            $organizationDetails->save();

            flash(translate('Organization details updated successfully!'))->success();
            return redirect()->route('organization.address');
        } else {
            $validatedData = $request->validate([
                // 'reg_type' => 'required|string',
                'work_area' => 'required|string',
                'organizationNameBangla' => ['required', 'string', 'max:255', 'regex:/^[\p{Bengali}0-9৳\s\p{P}]+$/u'],
                'organizationNameEnglish' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s\p{P}\p{S}]+$/u'],
                'org_type' => 'required|string',
                'establishment_date' => 'required|date',
            ]);
            $organizationDetails = new OrganizationDetails();

            $organizationDetails->user_id = $user_id;
            // $organizationDetails->reg_type = $request->input('reg_type');
            $organizationDetails->work_area = $request->input('work_area');
            $organizationDetails->org_name_bn = $request->input('organizationNameBangla');
            $organizationDetails->org_name_en = $request->input('organizationNameEnglish');
            $organizationDetails->org_type = $request->input('org_type');
            $organizationDetails->establishment_date = $request->input('establishment_date');
            $organizationDetails->logo = $request->input('organization_logo');

            $organizationDetails->save();

            flash(translate('Organization details saved successfully!'))->success();
            return redirect()->route('organization.address');
        }
    }

    // Organization address 
    public function create_address()
    {
        $user_id = Auth::id();
        $org_address = OrganizationAddress::where('user_id', $user_id)->first();
        $divisions = Division::where('status', 1)->orderBy('name', 'asc')->get();
        $districts = District::get();
        $sub_districts = Upazila::get();

        return view('organization.org_reg_forms.address_details', compact('org_address', 'districts', 'sub_districts', 'divisions'));
    }

    public function store_address(Request $request)
    {
        $user_id = Auth::id();
        $check_user_id = OrganizationAddress::where('user_id', $user_id)->exists();

        if ($check_user_id) {
            $request->validate([
                'division_id' => 'required',
                'district' => 'required',
                'sub_district' => 'required',
                'postOfficeBangla' => ['required', 'string', 'max:255', 'regex:/^[\p{Bengali}0-9৳\s\p{P}]+$/u'],
                'postOfficeEnglish' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s\p{P}\p{S}]+$/u'],
                'streetBangla' => ['required', 'string', 'max:255', 'regex:/^[\p{Bengali}0-9৳\s\p{P}]+$/u'],
                'streetEnglish' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s\p{P}\p{S}]+$/u'],
                'addressBangla' => ['required', 'string', 'max:255', 'regex:/^[\p{Bengali}0-9৳\s\p{P}]+$/u'],
                'addressEnglish' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s\p{P}\p{S}]+$/u'],
                'phone' => ['required', 'regex:/^[0-9]{11}$/'],
                'email' => 'required',
            ]);



            $address = OrganizationAddress::where('user_id', $user_id)->first();

            $address->user_id = $user_id;
            $address->division = $request->input('division_id');
            $address->district = $request->input('district');
            $address->sub_district = $request->input('sub_district');
            $address->post_office_bn = $request->input('postOfficeBangla');
            $address->post_office_en = $request->input('postOfficeEnglish');
            $address->street_bn = $request->input('streetBangla');
            $address->street_en = $request->input('streetEnglish');
            $address->address_bn = $request->input('addressBangla');
            $address->address_en = $request->input('addressEnglish');

            $address->phone = $request->input('phone');
            $address->email = $request->input('email');
            $address->website = $request->input('website');
            $address->facebook = $request->input('facebook');
            $address->linkedin = $request->input('linkedin');
            $address->twitter = $request->input('twitter');

            $address->save();

            flash(translate('Organization Address updated successfully!'))->success();
            return redirect()->route('organization.members');
        } else {
            $request->validate([
                'division_id' => 'required',
                'district' => 'required',
                'sub_district' => 'required',
                'postOfficeBangla' => ['required', 'string', 'max:255', 'regex:/^[\p{Bengali}0-9৳\s\p{P}]+$/u'],
                'postOfficeEnglish' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s\p{P}\p{S}]+$/u'],
                'streetBangla' => ['required', 'string', 'max:255', 'regex:/^[\p{Bengali}0-9৳\s\p{P}]+$/u'],
                'streetEnglish' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s\p{P}\p{S}]+$/u'],
                'addressBangla' => ['required', 'string', 'max:255', 'regex:/^[\p{Bengali}0-9৳\s\p{P}]+$/u'],
                'addressEnglish' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s\p{P}\p{S}]+$/u'],
                'phone' => ['required', 'regex:/^[0-9]{11}$/'],
                'email' => 'required',
            ]);

            $address = new OrganizationAddress();

            $address->user_id = $user_id;
            $address->division = $request->input('division_id');
            $address->district = $request->input('district');
            $address->sub_district = $request->input('sub_district');
            $address->post_office_bn = $request->input('postOfficeBangla');
            $address->post_office_en = $request->input('postOfficeEnglish');
            $address->street_bn = $request->input('streetBangla');
            $address->street_en = $request->input('streetEnglish');
            $address->address_bn = $request->input('addressBangla');
            $address->address_en = $request->input('addressEnglish');

            $address->phone = $request->input('phone');
            $address->email = $request->input('email');
            $address->website = $request->input('website');
            $address->facebook = $request->input('facebook');
            $address->linkedin = $request->input('linkedin');
            $address->twitter = $request->input('twitter');

            $address->save();

            flash(translate('Organization Address saved successfully!'))->success();
            return redirect()->route('organization.members');
        }
    }


    // Organization Members 
    public function create_members()
    {
        $user_id = Auth::id();
        $check_president_id = OrganizationMembers::where('user_id', $user_id)->where('designation', 'president')->first();
        $check_secretary_id = OrganizationMembers::where('user_id', $user_id)->where('designation', 'secretary')->first();
        return view('organization.org_reg_forms.members_details', compact('check_president_id', 'check_secretary_id'));
    }
    public function store_members(Request $request)
    {
        $user_id = Auth::id();
        $organization_id = OrganizationDetails::where('user_id', $user_id)->first();
        $check_president_id = OrganizationMembers::where('user_id', $user_id)->where('designation', 'president')->exists();
        $check_secretary_id = OrganizationMembers::where('user_id', $user_id)->where('designation', 'secretary')->exists();


        if ($check_president_id && $check_secretary_id) {
            $check_phone_no = OrganizationMembers::where('user_id', '!=', $user_id)  // Corrected the negation
                ->where('organization_id', '!=', $organization_id->id)  // Corrected the negation
                ->where(function ($query) use ($request) {
                    $query->where('phone', $request->presidentPhone)
                        ->orWhere('phone', $request->secretaryPhone);
                })
                ->exists();
            if ($check_phone_no) {

                flash(translate('Phone number already Exists!'))->error();
                return redirect()->back()->withInput();
            } else {

                $request->validate([
                    'presidentNameBangla' => ['required', 'string', 'max:255', 'regex:/^[\p{Bengali}0-9৳\s\p{P}]+$/u'],
                    'presidentNameEnglish' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s\p{P}\p{S}]+$/u'],
                    'presidentDOB' => 'required|date',
                    'presidentPhone' => [
                        'required',
                        'regex:/^[0-9]{11}$/',
                        function ($attribute, $value, $fail) use ($request) {
                            if ($value === $request->input('secretaryPhone')) {
                                $fail('The president\'s phone number cannot be the same as the secretary\'s phone number.');
                            }
                        },
                    ],
                    'presidentEmail' => 'required|email|max:255',
                    'presidentNID' => 'required|string|max:50',

                    'secretaryNameBangla' => ['required', 'string', 'max:255', 'regex:/^[\p{Bengali}0-9৳\s\p{P}]+$/u'],
                    'secretaryNameEnglish' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s\p{P}\p{S}]+$/u'],
                    'secretaryDOB' => 'required|date',
                    'secretaryPhone' => [
                        'required',
                        'regex:/^[0-9]{11}$/',
                        function ($attribute, $value, $fail) use ($request) {
                            if ($value === $request->input('presidentPhone')) {
                                $fail('The secretary\'s phone number cannot be the same as the president\'s phone number.');
                            }
                        },
                    ],
                    'secretaryEmail' => 'required|email|max:255',
                    'secretaryNID' => 'required|string|max:50',
                ]);

                // Array of members to update
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
                    $organizationMember = OrganizationMembers::where('user_id', $user_id)
                        ->where('organization_id', $organization_id->id)
                        ->where('designation', $memberData['designation'])
                        ->first();
                    $organizationMember->organization_id = $organization_id->id;
                    $organizationMember->user_id = $user_id;
                    $organizationMember->designation = $memberData['designation'];
                    $organizationMember->is_founder = '0';
                    $organizationMember->name_bn = $memberData['name_bn'];
                    $organizationMember->name_en = $memberData['name_en'];
                    $organizationMember->dob = $memberData['dob'];
                    $organizationMember->address = 'n/a';
                    $organizationMember->age = now()->diffInYears($memberData['dob']);
                    $organizationMember->nid = $memberData['nid'];
                    $organizationMember->phone = $memberData['phone'];
                    $organizationMember->email = $memberData['email'];
                    $organizationMember->image = $memberData['image'];
                    $organizationMember->save();
                }
                flash(translate('Leaders Detailsupdated successfully!'))->success();
                return redirect()->route('organization.bank');
            }
        } else {
            $check_phone_no = OrganizationMembers::where('phone', $request->presidentPhone)
                ->orWhere('phone', $request->secretaryPhone)
                ->exists();
            if ($check_phone_no) {

                flash(translate('Phone number already Exists!'))->error();
                return redirect()->back()->withInput();
            } else {

                $request->validate([
                    'presidentNameBangla' => ['required', 'string', 'max:255', 'regex:/^[\p{Bengali}0-9৳\s\p{P}]+$/u'],
                    'presidentNameEnglish' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s\p{P}\p{S}]+$/u'],
                    'presidentDOB' => 'required|date',
                    'presidentPhone' => [
                        'required',
                        'regex:/^[0-9]{11}$/',
                        function ($attribute, $value, $fail) use ($request) {
                            if ($value === $request->input('secretaryPhone')) {
                                $fail('The president\'s phone number cannot be the same as the secretary\'s phone number.');
                            }
                        },
                    ],
                    'presidentEmail' => 'required|email|max:255',
                    'presidentNID' => 'required|string|max:50',

                    'secretaryNameBangla' => ['required', 'string', 'max:255', 'regex:/^[\p{Bengali}0-9৳\s\p{P}]+$/u'],
                    'secretaryNameEnglish' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s\p{P}\p{S}]+$/u'],
                    'secretaryDOB' => 'required|date',
                    'secretaryPhone' => [
                        'required',
                        'regex:/^[0-9]{11}$/',
                        function ($attribute, $value, $fail) use ($request) {
                            if ($value === $request->input('presidentPhone')) {
                                $fail('The secretary\'s phone number cannot be the same as the president\'s phone number.');
                            }
                        },
                    ],
                    'secretaryEmail' => 'required|email|max:255',
                    'secretaryNID' => 'required|string|max:50',
                ]);


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


                    $organizationMember = new OrganizationMembers();
                    $organizationMember->organization_id = $organization_id->id;
                    $organizationMember->user_id = $user_id;
                    $organizationMember->designation = $memberData['designation'];
                    $organizationMember->is_founder = '0';
                    $organizationMember->name_bn = $memberData['name_bn'];
                    $organizationMember->name_en = $memberData['name_en'];
                    $organizationMember->dob = $memberData['dob'];
                    $organizationMember->address = 'n/a';
                    $organizationMember->age = now()->diffInYears($memberData['dob']);
                    $organizationMember->nid = $memberData['nid'];
                    $organizationMember->phone = $memberData['phone'];
                    $organizationMember->email = $memberData['email'];
                    $organizationMember->image = $memberData['image'];
                    $organizationMember->save();
                }

                flash(translate('Leaders Details saved successfully!'))->success();
                return redirect()->route('organization.bank');
            }
        }
    }



    // Organization Members 
    public function create_bank()
    {
        $user_id = Auth::id();
        $bank = OrganizationBank::where('user_id', $user_id)->first();
        return view('organization.org_reg_forms.bank_details', compact('bank'));
    }
    
    public function store_bank(Request $request)
    {
        $user_id = Auth::id();
        $organization_id = OrganizationDetails::where('user_id', $user_id)->first();
        $check_bank_create = OrganizationBank::where('user_id', $user_id)->exists();
        $check_bank_account = OrganizationBank::where('account_number', $request->accountNumber)->exists();
        $check_bank_account_update = OrganizationBank::where('account_number', $request->accountNumber)->where('user_id', !$user_id)->exists();


        if ($check_bank_create) {
            if ($check_bank_account_update) {

                flash(translate('Account already exists!'))->error();
                return redirect()->back()->withInput();
            } else {

                $validated = $request->validate([
                    'bankName' => 'required|string|max:255',
                    'branchName' => 'required|string|max:255',
                    'accountHolderName' => 'required|string|max:255',
                    'accountNumber' => 'required|string|max:255',
                    'sourceOfIncome' => 'required|string|max:255',
                ]);

                $organizationbank = OrganizationBank::where('user_id', $user_id)->first();

                $organizationbank->user_id = $user_id;
                $organizationbank->organization_id = $organization_id->id;
                $organizationbank->bank_name = $request->bankName;
                $organizationbank->branch_name = $request->branchName;
                $organizationbank->account_holder_name = $request->accountHolderName;
                $organizationbank->account_number = $request->accountNumber;
                $organizationbank->source_of_income = $request->sourceOfIncome;
                $organizationbank->save();

                flash(translate('Finance Details updated successfully!'))->success();
                return redirect()->route('organization.activity');
            }
        } else {
            if ($check_bank_account) {
                flash(translate('Account already exists!'))->error();
                return redirect()->back()->withInput();
            } else {

                $validated = $request->validate([
                    'bankName' => 'required|string|max:255',
                    'branchName' => 'required|string|max:255',
                    'accountHolderName' => 'required|string|max:255',
                    'accountNumber' => 'required|string|max:255',
                    'sourceOfIncome' => 'required|string|max:255',
                ]);

                $organizationbank = new OrganizationBank();

                $organizationbank->user_id = $user_id;
                $organizationbank->organization_id = $organization_id->id;
                $organizationbank->bank_name = $request->bankName;
                $organizationbank->branch_name = $request->branchName;
                $organizationbank->account_holder_name = $request->accountHolderName;
                $organizationbank->account_number = $request->accountNumber;
                $organizationbank->source_of_income = $request->sourceOfIncome;
                $organizationbank->save();

                flash(translate('Finance Details saved successfully!'))->success();
                return redirect()->route('organization.activity');
            }
        }
    }


    // organization activity
    public function create_activity()
    {
        $user_id = Auth::id();
        $organization_activity = OrganizationActivity::where('user_id', $user_id)->first();
        return view('organization.org_reg_forms.activity_details', compact('organization_activity'));
    }
    public function store_activity(Request $request)
    {
        $user_id = Auth::id();
        $organization_activity = OrganizationActivity::where('user_id', $user_id)->first();

        if ($organization_activity) {
            $validatedData = $request->validate([

                'lastMeetingDate' => 'required|date',
                'totalMembersLastMeeting' => 'required|integer',
                'objectives' => 'required|string',
                'planning' => 'required|string',
            ]);

            $organizationActivity = OrganizationActivity::where('user_id', $user_id)->first();

            $organizationActivity->user_id = $user_id;
            $organizationActivity->last_meeting_date = $validatedData['lastMeetingDate'];
            $organizationActivity->total_members_last_meeting = $validatedData['totalMembersLastMeeting'];
            $organizationActivity->members_opinion_doc = $request->members_opinion_doc ?? null;
            $organizationActivity->objectives = $validatedData['objectives'];
            $organizationActivity->objectives_doc = $request->objectives_doc ?? null;
            $organizationActivity->plan = $validatedData['planning'];
            $organizationActivity->plan_doc = $request->planning_doc ?? null;

            $organizationActivity->save();

            flash(translate('Activity Details updated successfully!'))->success();
        } else {
            $validatedData = $request->validate([

                'lastMeetingDate' => 'required|date',
                'totalMembersLastMeeting' => 'required|integer',
                'objectives' => 'required|string',
                'planning' => 'required|string',
            ]);

            $organizationActivity = new OrganizationActivity();

            $organizationActivity->user_id = $user_id;
            $organizationActivity->last_meeting_date = $validatedData['lastMeetingDate'];
            $organizationActivity->total_members_last_meeting = $validatedData['totalMembersLastMeeting'];
            $organizationActivity->members_opinion_doc = $request->members_opinion_doc ?? null;
            $organizationActivity->objectives = $validatedData['objectives'];
            $organizationActivity->objectives_doc = $request->objectives_doc ?? null;
            $organizationActivity->plan = $validatedData['planning'];
            $organizationActivity->plan_doc = $request->planning_doc ?? null;

            $organizationActivity->save();

            flash(translate('Activity Details saved successfully!'))->success();
        }
        return redirect()->route('organization.domain');
    }



    // domain 
    public function create_domain()
    {
        $domains = DomainOfWork::get();
        return view('organization.org_reg_forms.domains_of_work', compact('domains'));
    }

    public function domains_store(Request $request)
    {
        $user_id = Auth::id();

        
        $request->validate([
            'org_domains' => 'array',
            'other_domain' => 'nullable|string|max:255',
        ]);

        $org_domain = new OrganizationDomain();

        $org_domain->user_id = $user_id;
        $org_domain->domain_id = $request->org_domains;
        $org_domain->others = $request->other_domain;
        $org_domain->save();
        flash(translate('Organization Domains saved successfully!'))->success();





        return redirect()->route('organization.challan');
    }



    // challan 
    public function create_challan()
    {
        $user_id = Auth::id();
        $documents = OrganizationDocument::where('user_id', $user_id)->first();
        return view('organization.org_reg_forms.challan', compact('documents'));
    }
    public function challan_store(Request $request)
    {
        $user_id = Auth::id();
        $organization_id = OrganizationDetails::where('user_id', $user_id)->first();
        $check_for_edit = OrganizationDocument::where('user_id', $user_id)->exists();

        if ($check_for_edit) {
            $request->validate([
                'challan' => 'required',
            ]);

            $organization_doc = OrganizationDocument::where('user_id', $user_id)->first();
            $organization_doc->user_id = $user_id;
            $organization_doc->organization_id = $organization_id->id;
            $organization_doc->challan = $request->challan;

            $organization_doc->save();

            flash(translate('Challan updated successfully!'))->success();
        } else {
            $request->validate([
                'challan' => 'required',

            ]);

            $organization_doc = new OrganizationDocument();
            $organization_doc->user_id = $user_id;
            $organization_doc->organization_id = $organization_id->id;
            $organization_doc->challan = $request->challan;
            $organization_doc->save();

            flash(translate('Challan saved successfully!'))->success();
        }
        return redirect()->route('organization.documents');
    }


    // documents 
    public function create_document()
    {
        $user_id = Auth::id();
        $documents = OrganizationDocument::where('user_id', $user_id)->first();
        return view('organization.org_reg_forms.document', compact('documents'));
    }
    public function document_store(Request $request)
    {
        $user_id = Auth::id();
        $organization_id = OrganizationDetails::where('user_id', $user_id)->first();
        $check_for_edit = OrganizationDocument::where('user_id', $user_id)->exists();

        if ($check_for_edit) {
            $request->validate([
                'constitution' => 'required',
                'general_members' => 'required',
                'council_members' => 'required',
            ]);

            $organization_doc = OrganizationDocument::where('user_id', $user_id)->first();
            $organization_doc->user_id = $user_id;
            $organization_doc->organization_id = $organization_id->id;
            $organization_doc->constitution = $request->constitution;
            $organization_doc->general_members = $request->general_members;
            $organization_doc->council_members = $request->council_members;
            $organization_doc->save();

            flash(translate('Documnets updated successfully!'))->success();
        } else {
            $request->validate([
                'constitution' => 'required',
                'general_members' => 'required',
                'council_members' => 'required',
            ]);

            $organization_doc = new OrganizationDocument();
            $organization_doc->user_id = $user_id;
            $organization_doc->organization_id = $organization_id->id;
            $organization_doc->constitution = $request->constitution;
            $organization_doc->general_members = $request->general_members;
            $organization_doc->council_members = $request->council_members;
            $organization_doc->save();

            flash(translate('Documnets saved successfully!'))->success();
        }

        return redirect()->route('organization.show');
    }



    // Submit 
    public function show()
    {
        $user_id = Auth::id();

        $districts = District::get();
        $sub_districts = Upazila::get();
        $divisions = Division::get();
        $documents = OrganizationDocument::where('user_id', $user_id)->first();
        $bank = OrganizationBank::where('user_id', $user_id)->first();
        $org_address = OrganizationAddress::where('user_id', $user_id)->first();
        $org_details = OrganizationDetails::where('user_id', $user_id)->first();
        $organization_activity = OrganizationActivity::where('user_id', $user_id)->first();
        $check_president_id = OrganizationMembers::where('user_id', $user_id)->where('designation', 'president')->first();
        $check_secretary_id = OrganizationMembers::where('user_id', $user_id)->where('designation', 'secretary')->first();

        return view('organization.org_reg_forms.submit', compact('organization_activity', 'org_address', 'org_details', 'districts', 'sub_districts', 'check_president_id', 'check_secretary_id', 'bank', 'divisions', 'documents'));
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
        $organization->status = 1;
        $organization->save();

        flash(translate('Organization submitted for verification successfully!'))->success();
        return redirect()->route('organization.dashboard');
    }
}
