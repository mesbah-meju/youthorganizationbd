<?php

namespace App\Http\Controllers\Organization;

use App\Http\Requests\OrganizationProfileRequest;
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
        $addresses = $user->address ? collect([$user->address]) : collect(); 
        return view('organization.profile.index', compact('user','addresses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrganizationProfileRequest $request , $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;

        if($request->new_password != null && ($request->new_password == $request->confirm_password)) {
            $user->password = Hash::make($request->new_password);
        }

        $user->avatar_original = $request->photo;
        $user->save();

        flash(translate('Your Profile has been updated successfully!'))->success();
        return back();
    }
}
