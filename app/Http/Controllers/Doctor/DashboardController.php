<?php

namespace App\Http\Controllers\Doctor;

class DashboardController extends Controller
{
    public function index()
    {
        return view('doctor.dashboard');
    }
}
