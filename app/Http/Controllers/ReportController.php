<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Division;
use App\Models\DomainOfWork;
use App\Models\Organization;
use App\Models\Upazila;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:in_house_product_sale_report'])->only('in_house_sale_report');
        $this->middleware(['permission:seller_products_sale_report'])->only('seller_sale_report');
        $this->middleware(['permission:products_stock_report'])->only('stock_report');
        $this->middleware(['permission:product_wishlist_report'])->only('wish_report');
        $this->middleware(['permission:user_search_report'])->only('user_search_report');
        $this->middleware(['permission:commission_history_report'])->only('commission_history');
        $this->middleware(['permission:wallet_transaction_report'])->only('wallet_transaction_history');
    }
    public function deputy_directors_list_report(Request $request)
    {
        $division_id = $request->input('division_id');
        $district_id = $request->input('district_id');
        $upazila_id = $request->input('upazila_id');

        $divisions = Division::all();

        $deputyDirectorsQuery = User::where('user_type', 'directorate')->where('is_approved', '1')->select();

        if (!empty($division_id)) {
            $deputyDirectorsQuery->where('division', $division_id);
        }
        if (!empty($district_id)) {
            $deputyDirectorsQuery->where('district', $district_id);
        }
        if (!empty($upazila_id)) {
            $deputyDirectorsQuery->where('upazila', $upazila_id);
        }
        $deputyDirectors = $deputyDirectorsQuery->get();

        return view('backend.reports.deputy_directors_list_report', compact('deputyDirectors', 'divisions'));
    }


    public function organization_list_report(Request $request)
    {

        $division_id = $request->input('division_id');
        $district_id = $request->input('district_id');
        $upazila_id = $request->input('upazila_id');
        $domain_ids = $request->input('upazila_id[]');

        // dd($domain_id);

        $domains = DomainOfWork::get();

        $divisions = Division::all();

        $organizationQuery = Organization::where('status', '2')
            ->leftJoin('organization_addresses', 'organization_addresses.user_id', '=', 'organizations.user_id')
            ->leftJoin('organization_members', function ($join) {
                $join->on('organization_members.user_id', '=', 'organizations.user_id')
                    ->where('organization_members.designation', 'president');
            })
            ->leftJoin('organization_domain_of_works', 'organization_domain_of_works.user_id', '=', 'organizations.user_id')
            ->select('organizations.*', 'organization_addresses.*', 'organization_members.*', 'organization_domain_of_works.domain_id');

        // Apply filters if values are provided
        if (!empty($division_id)) {
            $organizationQuery->where('organization_addresses.division_id', $division_id);
        }

        if (!empty($district_id)) {
            $organizationQuery->where('organization_addresses.district_id', $district_id);
        }

        if (!empty($upazila_id)) {
            $organizationQuery->where('organization_addresses.upazila_id', $upazila_id);
        }

        if (!empty($domain_ids) && is_array($domain_ids)) {
            $organizationQuery->where(function ($query) use ($domain_ids) {
                foreach ($domain_ids as $domain_id) {
                    $query->orWhereJsonContains('organization_domain_of_works->domain_id', $domain_id);
                }
            });
        }

        $organization = $organizationQuery->get();

        return view('backend.reports.organization_list_report', compact('organization', 'divisions', 'domains'));
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
