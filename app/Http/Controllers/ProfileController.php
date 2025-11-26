<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\District;
use App\Models\Division;
use App\Models\Upazila;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $divisions = Division::get();
        $districts = District::where('division_id',$user->division)->get();
        $upazilas = Upazila::where('district_id',$user->district)->get();

        return view('backend.admin_profile.index',compact('divisions','districts','upazilas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->gov_id = $request->gov_id;
        $user->joining_date = $request->joining_date;
        $user->division = $request->division_id;
        $user->district = $request->district_id;
        $user->upazila = $request->upazila_id;

        if($request->new_password != null && ($request->new_password == $request->confirm_password)) {
            $user->password = Hash::make($request->new_password);
        }

        $user->avatar_original = $request->avatar;

        if ($user->save()) {
            flash(translate('Your profile has been updated successfully!'))->success();
            return back();
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }
}
