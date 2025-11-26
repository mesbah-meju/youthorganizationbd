<?php

namespace App\Http\Controllers;

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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view_all_organization'])->only('index');
        $this->middleware(['permission:add_organization'])->only('create');
        $this->middleware(['permission:edit_organization'])->only('edit');
        $this->middleware(['permission:delete_organization'])->only('destroy');
        $this->middleware(['permission:login_as_organization'])->only('login');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort_search = null;

        $user = Auth::user();

        $organizations = Organization::query();

        if ($request->sort_search) {
            $sort_search = $request->sort_search;
            $organizations->where(function ($organization) use ($sort_search) {
                $organization->where('name', 'like', '%' . $sort_search . '%');
            });
        }

        if ($user->userrole && ($user->userrole->role_id == 4 || $user->userrole->role_id == 5 || $user->userrole->role_id == 6)) {
            if ($user->userrole->role_id == 5 || $user->userrole->role_id == 6) {
                $organizations->whereHas('address', function ($query) use ($user) {
                    if ($user->district) {
                        $query->where('district_id', $user->district);
                    }

                    if ($user->upazila) {
                        $query->where('upazila_id', $user->upazila);
                    }
                });
            } else {
                $organizations->whereHas('address', function ($query) use ($user) {
                    if ($user->district) {
                        $query->where('division_id', $user->division);
                    }
                });
            }
        }

        $organizations = $organizations->orderBy('id', 'desc')->paginate(15);

        return view('backend.organizations.index', compact('organizations', 'sort_search'));
    }

    /**
     * Display a listing of the resource.
     */
    public function pending(Request $request)
    {
        $sort_search = null;

        $user = Auth::user();

        $organizations = Organization::where('status', 1);

        if ($request->sort_search) {
            $sort_search = $request->sort_search;
            $organizations->where(function ($organization) use ($sort_search) {
                $organization->where('name', 'like', '%' . $sort_search . '%');
            });
        }

        if ($user->userrole && ($user->userrole->role_id == 4 || $user->userrole->role_id == 5 || $user->userrole->role_id == 6)) {
            if ($user->userrole->role_id == 5 || $user->userrole->role_id == 6) {
                $organizations->whereHas('address', function ($query) use ($user) {
                    if ($user->district) {
                        $query->where('district_id', $user->district);
                    }

                    // Filter by upazila_id
                    if ($user->upazila) {
                        $query->where('upazila_id', $user->upazila);
                    }
                });
            } else {
                $organizations->whereHas('address', function ($query) use ($user) {
                    if ($user->district) {
                        $query->where('division_id', $user->division);
                    }
                });
            }
        }

        $organizations = $organizations->orderBy('id', 'desc')->paginate(15);

        return view('backend.organizations.pending', compact('organizations', 'sort_search'));
    }


    /**
     * Display a listing of the resource.
     */
    public function approved(Request $request)
    {
        $sort_search = null;
        $user = Auth::user();

        $organizations = Organization::where('status', 2);

        if ($request->sort_search) {
            $sort_search = $request->sort_search;
            $organizations->where(function ($organization) use ($sort_search) {
                $organization->where('name', 'like', '%' . $sort_search . '%');
            });
        }

        if ($user->userrole && ($user->userrole->role_id == 4 || $user->userrole->role_id == 5 || $user->userrole->role_id == 6)) {
            if ($user->userrole->role_id == 5 || $user->userrole->role_id == 6) {
                $organizations->whereHas('address', function ($query) use ($user) {
                    if ($user->district) {
                        $query->where('district_id', $user->district);
                    }

                    // Filter by upazila_id
                    if ($user->upazila) {
                        $query->where('upazila_id', $user->upazila);
                    }
                });
            } else {
                $organizations->whereHas('address', function ($query) use ($user) {
                    if ($user->district) {
                        $query->where('division_id', $user->division);
                    }
                });
            }
        }

        $organizations = $organizations->orderBy('id', 'desc')->paginate(15);

        return view('backend.organizations.approved', compact('organizations', 'sort_search'));
    }


    /**
     * Display a listing of the resource.
     */
    public function rejected(Request $request)
    {
        $sort_search = null;
        $user = Auth::user();

        $organizations = Organization::where('status', 3);

        if ($request->sort_search) {
            $sort_search = $request->sort_search;
            $organizations->where(function ($organization) use ($sort_search) {
                $organization->where('name', 'like', '%' . $sort_search . '%');
            });
        }

        if ($user->userrole && ($user->userrole->role_id == 4 || $user->userrole->role_id == 5 || $user->userrole->role_id == 6)) {
            if ($user->userrole->role_id == 5 || $user->userrole->role_id == 6) {
                $organizations->whereHas('address', function ($query) use ($user) {
                    if ($user->district) {
                        $query->where('district_id', $user->district);
                    }

                    // Filter by upazila_id
                    if ($user->upazila) {
                        $query->where('upazila_id', $user->upazila);
                    }
                });
            } else {
                $organizations->whereHas('address', function ($query) use ($user) {
                    if ($user->district) {
                        $query->where('division_id', $user->division);
                    }
                });
            }
        }

        $organizations = $organizations->orderBy('id', 'desc')->paginate(15);

        return view('backend.organizations.rejected', compact('organizations', 'sort_search'));
    }

    /**
     * Display a listing of the resource.
     */
    public function search(Request $request)
    {
        $sort_search = null;

        $user = Auth::user();

        $organizations = Organization::query();

        if ($request->sort_search) {
            $sort_search = $request->sort_search;
            $organizations->where(function ($organization) use ($sort_search) {
                $organization->where('name', 'like', '%' . $sort_search . '%');
            });
        }

        if ($user->userrole && ($user->userrole->role_id == 4 || $user->userrole->role_id == 5 || $user->userrole->role_id == 6)) {
            if ($user->userrole->role_id == 5 || $user->userrole->role_id == 6) {
                $organizations->whereHas('address', function ($query) use ($user) {
                    if ($user->district) {
                        $query->where('district_id', $user->district);
                    }

                    // Filter by upazila_id
                    if ($user->upazila) {
                        $query->where('upazila_id', $user->upazila);
                    }
                });
            } else {
                $organizations->whereHas('address', function ($query) use ($user) {
                    if ($user->district) {
                        $query->where('division_id', $user->division);
                    }
                });
            }
        }

        $organizations = $organizations->orderBy('id', 'desc')->paginate(15);

        return view('backend.organizations.search', compact('organizations', 'sort_search'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $divisions = Division::get();
        $districts = District::get();
        $sub_districts = Upazila::get();

        $organization = Organization::findOrFail($id);

        $documents = OrganizationDocument::where('user_id', $organization->user_id)->first();
        $banks = OrganizationBank::where('user_id', $organization->user_id)->get();
        $organization_award = OrganizationAward::where('user_id', $organization->user_id)->get();
        $organization_grant = OrganizationGrant::where('user_id', $organization->user_id)->get();

        $org_address = OrganizationAddress::where('user_id', $organization->user_id)->first();
        $org_details = Organization::where('user_id', $organization->user_id)->first();
        $organization_activity = OrganizationActivity::where('user_id', $organization->user_id)->first();
        $check_president_id = OrganizationMember::where('user_id', $organization->user_id)->where('designation', 'president')->first();
        $check_secretary_id = OrganizationMember::where('user_id', $organization->user_id)->where('designation', 'secretary')->first();

        $check_english_id = OrganizationMember::where('user_id', $organization->user_id)->where('designation','!=','secretary')->where('designation','!=','president')->first();

        $domains = DomainOfWork::get();
        $org_domains = OrganizationDomain::where('user_id', $organization->user_id)->first();
        if ($org_domains) {
            $domains_id = json_decode($org_domains->domain_id);
            $other = $org_domains->others;
        } else {
            $domains_id = [];
            $other = '';
        }
        return view('backend.organizations.show', compact('organization', 'organization_activity', 'org_address', 'org_details', 'districts', 'sub_districts', 'check_president_id', 'check_secretary_id', 'check_english_id','banks', 'organization_award','organization_grant', 'divisions', 'documents', 'domains', 'domains_id', 'other'));
    }

    public function approve(Request $request, string $id)
    {
        $organization = Organization::findOrFail($id);
        $organization->approved_reason = $request->reason;
        $organization->approved_at = date('Y-m-d H:i:s');
        $organization->approved_by = Auth::user()->id;
        $organization->reg_type = "registered";
        $organization->status = 2; // 2 for approved
        $organization->save();

        flash('Organization has been approved successfully')->success();
        return back();
    }

    public function reject(Request $request, string $id)
    {
        $organization = Organization::findOrFail($id);
        $organization->rejected_reason = $request->reason;
        $organization->rejected_at = date('Y-m-d H:i:s');
        $organization->rejected_by = Auth::user()->id;
        $organization->status = 3; // 3 for rejected
        $organization->save();
        flash('Organization has been rejected successfully')->success();
        return back();
    }

    public function countryWiseDivision($id)
    {
        $divisions = Division::where('country_id', $id)->orderBy('name', 'asc')->get();
        $options = '<option value="">' . 'Select a division' . '</option>';
        foreach ($divisions as $division) {
            $options .= '<option value="' . $division->id . '">' . $division->name . '</option>';
        }
        return $options;
    }

    public function divisionWiseDistrict($id)
    {
        $districts = District::where('division_id', $id)->orderBy('name', 'asc')->get();
        $options = '<option value="">' . 'Select a district' . '</option>';
        foreach ($districts as $district) {
            $options .= '<option value="' . $district->id . '">' . $district->name . '</option>';
        }
        return $options;
    }

    public function districtWiseUpazila($id)
    {
        $upazilas = Upazila::where('district_id', $id)->orderBy('name', 'asc')->get();
        $options = '<option value="">' . 'Select a upazila' . '</option>';
        foreach ($upazilas as $upazila) {
            $options .= '<option value="' . $upazila->id . '">' . $upazila->name . '</option>';
        }
        return $options;
    }
}
