<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\District;
use App\Models\Division;
use App\Models\Upazila;
use Artisan;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;


class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_dashboard(Request $request)
    {
        $user = Auth::user();
        $admin_user = User::where('user_type', 'developer')->first();
        $admin_user->syncRoles(['System Engineer']);

        $admin_user = User::where('user_type', 'admin')->first();
        $admin_user->syncRoles(['Super Admin']);
        $d_director = User::where('user_type', 'directorate')->count();
        $organization = User::where('user_type', 'organization')->count();

        $divisions = Division::count();
        $districts = District::count();
        $upazila = Upazila::count();


        return view('backend.dashboard', compact('d_director', 'organization', 'divisions', 'districts', 'upazila'));
    }

    function clearCache(Request $request)
    {
        Artisan::call('optimize:clear');
        flash(translate('Cache cleared successfully'))->success();
        return back();
    }
}
