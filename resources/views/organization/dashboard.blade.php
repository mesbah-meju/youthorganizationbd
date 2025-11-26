@extends('organization.layouts.app')

@section('panel_content')
    <div class="text-center mx-5">
        <h3 class="bg-success text-white rounded py-3 px-2 mx-5 shadow-lg">
            Welcome to Youth Organization Database, Bangladesh
        </h3>
    </div>
    <div class="row mt-4">
        <!-- Card 1 -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="{{ route('organization.details.create') }}"
                class="d-block {{ $org_details->status != 0 ? 'disabled-link' : '' }}">
                <div class="card card-stats">
                    <div class="card-header" @if ($check_details)
                    style="background: linear-gradient(60deg, #0abb75, #0abb75) !important;" @endif>
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <div class="col-8">
                            <p class="category">#1</p>
                            <h3 class="card-title">Registration Details</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 2 -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="{{ route('organization.address.create') }}"
                class="d-block {{ $org_details->status == 1 ? 'disabled-link' : '' }}">
                <div class="card card-stats">
                    <div class="card-header" @if ($check_address)
                    style="background: linear-gradient(60deg, #0abb75, #0abb75) !important;" @endif>
                        <i class="material-icons">gps_fixed</i>

                    </div>
                    <div class="card-content">
                        <div class="col-lg-8">
                            <p class="category">#2</p>
                            <h3 class="card-title">Address & Social Media</h3>
                        </div>
                    </div>
                </div>
            </a>

        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="{{ route('organization.members.create') }}"
                class="d-block {{ $org_details->status == 1 ? 'disabled-link' : '' }}">
                <div class="card card-stats">
                    <div class="card-header" @if ($check_member)
                    style="background: linear-gradient(60deg, #0abb75, #0abb75) !important;" @endif>
                        <i class="material-icons">person</i>
                    </div>
                    <div class="card-content">
                        <div class="col-8">
                            <p class="category">#3</p>
                            <h3 class="card-title">Key Persons</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="{{ route('organization.banks.create') }}"
                class="d-block {{ $org_details->status == 1 ? 'disabled-link' : '' }}">
                <div class="card card-stats">
                    <div class="card-header" @if ($check_bank)
                    style="background: linear-gradient(60deg, #0abb75, #0abb75) !important;" @endif>
                        <i class="material-icons">business_center</i>
                    </div>
                    <div class="card-content">
                        <div class="col-8">
                            <p class="category">#4</p>
                            <h3 class="card-title">Bank information</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="{{ route('organization.activity.create') }}"
                class="d-block {{ $org_details->status == 1 ? 'disabled-link' : '' }}">
                <div class="card card-stats">
                    <div class="card-header" @if ($check_social)
                    style="background: linear-gradient(60deg, #0abb75, #0abb75) !important;" @endif>
                        <i class="material-icons">language</i>
                    </div>
                    <div class="card-content">
                        <div class="col-8">
                            <p class="category">#5</p>
                            <h3 class="card-title">Activities</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        @if($check_details && $org_details->reg_type == 'registered')
            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{route('organization.awards.create')}}"
                    class="d-block {{ ($org_details->status == 1) ? 'disabled-link' : '' }}">
                    <div class="card card-stats">
                        <div class="card-header" @if ($check_award)
                        style="background: linear-gradient(60deg, #0abb75, #0abb75) !important;" @endif>
                            <i class="material-icons">star</i>
                        </div>
                        <div class="card-content">
                            <div class="col-8">
                                <p class="category">#6</p>
                                <h3 class="card-title">Awards & Achievements</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{route('organization.grants.create')}}"
                    class="d-block {{ ($org_details->status == 1) ? 'disabled-link' : '' }}">
                    <div class="card card-stats">
                        <div class="card-header" @if ($check_grant)
                        style="background: linear-gradient(60deg, #0abb75, #0abb75) !important;" @endif>
                            <i class="material-icons">volunteer_activism</i>
                        </div>
                        <div class="card-content">
                            <div class="col-8">
                                <p class="category">#7</p>
                                <h3 class="card-title">Grants and Aids</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endif

        <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="{{route('organization.domains.create')}}"
                class="d-block {{ $org_details->status == 1 ? 'disabled-link' : '' }}">
                <div class="card card-stats">
                    <div class="card-header" @if ($check_domain)
                    style="background: linear-gradient(60deg, #0abb75, #0abb75) !important;" @endif>
                        <i class="material-icons">terminal</i>
                    </div>
                    <div class="card-content">
                        <div class="col-8">
                            <p class="category">#8</p>
                            <h3 class="card-title">Domains of Work</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="{{route('organization.challan.create')}}"
                class="d-block {{ $org_details->status != 0 ? 'disabled-link' : '' }}">
                <div class="card card-stats">
                    <div class="card-header" @if ($check_challan)
                    style="background: linear-gradient(60deg, #0abb75, #0abb75) !important;" @endif>
                        <i class="material-icons">book</i>
                    </div>
                    <div class="card-content">
                        <div class="col-8">
                            <p class="category">#9</p>
                            <h3 class="card-title">Upload Challan</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="{{route('organization.documents.create')}}"
                class="d-block {{ $org_details->status != 0 ? 'disabled-link' : '' }}">
                <div class="card card-stats">
                    <div class="card-header" @if ($check_docs)
                    style="background: linear-gradient(60deg, #0abb75, #0abb75) !important;" @endif>
                        <i class="material-icons">import_contacts</i>
                    </div>
                    <div class="card-content">
                        <div class="col-8">
                            <p class="category">#10</p>
                            <h3 class="card-title">Supporting Documents</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            @if ($check_details && $check_address && $check_member && $check_bank && $check_social && $check_challan && $check_docs)
                @if($org_details->status == 0)
                    <a href="{{route('organization.show')}}" class="d-block">
                        <div class="card card-stats">
                            <div class="card-header"
                                style="background: linear-gradient(60deg,rgb(10, 142, 89),rgb(13, 127, 81)) !important;">
                                <i class="material-icons">send</i>
                            </div>
                            <div class="card-content">
                                <div class="col-8">
                                    <p class="category">#11</p>
                                    <h3 class="card-title">Submit for Verification</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                @elseif(($org_details->status == 1 || $org_details->status == 2))
                    <a href="{{route('organization.show')}}" class="d-block disabled-link">
                        <div class="card card-stats">
                            <div class="card-header"
                                style="background: linear-gradient(60deg,rgb(10, 142, 89),rgb(13, 127, 81)) !important;">
                                <i class="material-icons">send</i>
                            </div>
                            <div class="card-content">
                                <div class="col-8">
                                    <p class="category">#11</p>
                                    <h3 class="card-title">Submit for Verification</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                @else 
                    <a href="{{route('organization.show')}}" class="d-block">
                        <div class="card card-stats">
                            <div class="card-header" style="background: linear-gradient(60deg, #ef5350, #e53935) !important;">
                                <i class="material-icons">send</i>
                            </div>
                            <div class="card-content">
                                <div class="col-8">
                                    <p class="category">#11</p>
                                    <h3 class="card-title">Re-Submit for Verification</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                @endif
            @else
                <div class="card card-stats">
                    <div class="card-header"
                        style="background: linear-gradient(60deg,rgb(135, 7, 107),rgb(148, 8, 109)) !important;">
                        <i class="material-icons">send</i>
                    </div>
                    <div class="card-content">
                        <div class="col-8">
                            <p class="category">#11</p>
                            <h3 class="card-title">Submit for Verification</h3>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @if($org_details->status == 1)

            <div class="col-lg-3 col-md-6 col-sm-6"> <a href="{{route('organization.show')}}" class="d-block">
                    <div class="card card-stats">
                        <div class="card-header">
                            <i class="material-icons">settings</i>
                        </div>
                        <div class="card-content">
                            <div class="col-8">
                                <p class="category">#12</p>
                                <h3 class="card-title">Pending for Approval</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        @elseif($org_details->status == 2)

            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{route('organization.show')}}" class="d-block">
                    <div class="card card-stats">
                        <div class="card-header"
                            style="background: linear-gradient(60deg,rgb(10, 142, 89),rgb(13, 127, 81)) !important;">
                            <i class="material-icons">settings</i>
                        </div>
                        <div class="card-content">
                            <div class="col-8">
                                <p class="category">#12</p>
                                <h3 class="card-title">Approved</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        @elseif($org_details->status == 3)
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header" style="background: linear-gradient(60deg, rgb(232 4 4), rgb(238 7 7)) !important;">
                        <i class="material-icons">settings</i>
                    </div>
                    <div class="card-content">
                        <div class="col-8">
                            <p class="category">#12</p>
                            <h3 class="card-title">Rejected</h3>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>



    <style>
        .disabled-link {
            pointer-events: none;
            opacity: 0.6;
            cursor: not-allowed;
        }

        .card {
            border: none;
            background-color: #15151500;
        }

        .card-header {
            height: 75px;
            width: 75px;
            border-radius: 3px !important;
            border: none !important;
            box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(244, 67, 54, 0.4);
            background: linear-gradient(60deg, #ef5350, #e53935) !important;
            justify-content: center !important;
            align-items: center;
            margin-bottom: -55px;
            margin-left: 16px;

        }

        .card-header i {
            font-size: 30px;
            color: #ffffff;
        }


        .card-content {
            height: 120px;
            width: 100%;
            border: none;
            border-radius: 6px;
            background-color: #ffffff;
            box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.14);
            overflow: hidden;
            text-align: right;
            padding: 25px 4px;
            display: flex;
            justify-content: end;
        }

        .card-content .category {
            font-size: 14px;
            color: #757575;
            /* Light gray for the category */
            margin: 0;
        }

        .card-content .card-title {
            font-size: 20px;
            color: rgb(113, 113, 113);
            /* Dark text for the title */
            font-weight: 300;
            margin: 5px 0 0;
        }
    </style>
@endsection