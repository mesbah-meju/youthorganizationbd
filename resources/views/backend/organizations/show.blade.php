@extends('backend.layouts.app')

@section('content')
    <style>
        .aiz-content-wrapper {
            font-size: 14px;
            line-height: 40px;
        }

        .overflow_text {
            height: 300px;
            overflow-y: auto;
        }

        strong {
            font-weight: 600 !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
    <div class="container border shadow rounded mt-3 mb-3 p-0 text-center">
        <h4 class="bg-success text-white rounded py-3 px-2 m-0 shadow-lg">
            Welcome to Youth Organization Database, Bangladesh
        </h4>
    </div>
    <div class="container bg-white border shadow rounded px-5 py-4 mt-5 mb-3">
        <h5 class="text-center text-decoration-underline">সংগঠনের তথ্য (Organization's Information)</h5>
        <div class="row mt-4 d-flex">
            <div class="col-md-4 d-flex align-items-center justify-content-center">
                <img src="{{ uploaded_asset($org_details->logo) }}" style="height: 180px; width: 180px;"
                    alt="Organization Logo">
            </div>

            <div class="col-md-8 align-items-center border-left">
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <strong> নিবন্ধনের ধরণ(Registration Type) :</strong>
                        @if ($org_details->reg_type == 'new')
                            <span class="p-2 rounded bg-soft-success">এই সংস্থাটি নতুন নিবন্ধন করছে।</span>
                        @else
                            <span class="p-2 rounded bg-soft-primary">এই সংস্থা পূর্বে নিবন্ধন করা হয়েছে</span>
                        @endif
                    </div>
                    <div class="col-md-6 mt-2">
                        <strong>সংগঠনের নাম: </strong>{{$org_details->org_name_bn}}
                    </div>
                    <div class="col-md-6 mt-2">
                        <strong>Organization Name: </strong>{{$org_details->org_name_en}}
                    </div>
                    @if ($org_details->reg_no)
                        <div class="col-md-6 mt-2">
                            <strong>নিবন্ধন নম্বর(Registration No.): </strong>{{$org_details->reg_no}}
                        </div>
                    @endif

                    <div class="col-md-6 mt-2">
                        <strong>সংগঠনের ধরণ :</strong>
                        @if($org_details->org_type == 'General') সাধারণ (General)
                        @elseif($org_details->org_type == 'Youth Women') যুবনারী (Youth Women)
                        @elseif($org_details->org_type == 'Youth Disabled') যুবপ্রতিবন্ধী (Youth Disabled)
                        @elseif($org_details->org_type == 'Special Needs') বিশেষ চাহিদা সম্পন্ন (Special Needs)
                        @elseif($org_details->org_type == 'Third Gender') তৃতীয় লিঙ্গ (Third Gender)
                        @elseif($org_details->org_type == 'Youth Women and Disabled') যুবনারী ও প্রতিবন্ধী (Youth Women a
                            n d Disabled)
                        @endif

                    </div>
                    <div class="col-md-6 mt-2">
                        <strong>প্রতিষ্ঠার তারিখ :</strong> {{$org_details->established_date}}
                    </div>
                    <div class="col-md-6 mt-2">
                        <strong>কর্মক্ষেত্র : </strong>
                        @if($org_details->work_area == 'local') স্থানীয়
                        @elseif($org_details->work_area == 'upazila') উপজেলা
                        @elseif($org_details->work_area == 'district') জেলা
                        @elseif($org_details->work_area == 'other') অন্যান্য
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container bg-white border shadow rounded px-5 pt-4 pb-5 my-3">
        <h5 class="mb-4 text-center">যোগাযোগের মাধ্যম (Media of Communication)</h5>

        <h6 class="mt-4">সংগঠনের ঠিকানা :</h6>
        <div class="row">
            <div class="col-md-3 mt-4  border-right">
                <strong>বিভাগ (Division) :</strong>
                {{ $divisions->firstWhere('id', $org_address->division_id)->name ?? 'No division selected' }}
                <br>
                <strong>জেলা (District) :</strong>
                {{ $districts->firstWhere('id', $org_address->district_id)->name ?? 'No district selected' }}
                <br>
                <strong>উপজেলা (Sub-District) :</strong>
                {{ $sub_districts->firstWhere('id', $org_address->upazila_id)->name ?? 'No sub-district selected' }}
            </div>

            <div class="col-md-3 mt-4 border-right">
                <h6>ডাকঘর :</h6>
                <ul>
                    <li><strong>বাংলা:</strong> {{$org_address->post_office_bn}}</li>
                    <li><strong>English :</strong> {{$org_address->post_office_en}}</li>
                </ul>
            </div>
            <div class="col-md-3 mt-4 border-right">
                <h6>সড়ক/ব্লক/সেক্টর :</h6>
                <ul>
                    <li><strong>বাংলা:</strong> {{$org_address->street_bn}}</li>
                    <li><strong>English :</strong> {{$org_address->street_en}}</li>
                </ul>
            </div>
            <div class="col-md-3 mt-4">
                <h6>বাড়ি/গ্রাম/মহল্লা :</h6>
                <ul>
                    <li><strong>বাংলা:</strong> {{$org_address->address_bn}}</li>
                    <li><strong>English :</strong> {{$org_address->address_en}}</li>
                </ul>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6 mt-4 border-right">
                <h6>যোগাযোগের তথ্য :</h6>
                <ul>
                    <li><strong>ফোন নম্বর (Phone) :</strong> {{$org_address->phone}}</li>
                    <li><strong>ইমেইল (Email) :</strong> {{$org_address->email}}</li>
                    <li><strong>ওয়েবসাইট (Website) :</strong> {{$org_address->website}}</li>
                </ul>
            </div>

            <div class="col-md-6 mt-4">
                <h6>সামাজিক যোগাযোগ মাধ্যমের তথ্য :</h6>
                <ul>
                    <li><strong>ফেসবুক (Facebook) :</strong> {{$org_address->facebook}}</li>
                    <li><strong>লিঙ্কডইন (LinkedIn) :</strong> {{$org_address->linkedin}}</li>
                    <li><strong>টুইটার (Twitter) :</strong> {{$org_address->twitter}}</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container my-3">
        <div class="row">
            <!-- President Information -->
            <div class="col-md-6 pl-0 pr-1">
                <div class="card mb-0 shadow-sm p-5">
                    <div class="row">
                        <!-- Image Section -->
                        <div class="col-md-12 text-center mb-4">
                            <img src="{{ uploaded_asset($check_president_id->image) }}" style="height: 180px; width:150px"
                                alt="President's Image" class="rounded-circle">
                        </div>
                        <!-- Name Section -->
                        <div class="col-md-12 text-center">
                            <h6>{{ $check_president_id->name_bn ?? 'তথ্য নেই' }}</h6>
                            <h6>{{ $check_president_id->name_en ?? 'তথ্য নেই' }}</h6>
                        </div>
                        <!-- Birthdate -->
                        <div class="col-md-6 mt-4">
                            <label for="presidentDOB" class="form-label"><strong>জন্ম তারিখ (Date of Birth)</strong></label>
                            <input type="text" class="form-control border-0 text-dark" id="presidentDOB"
                                value="{{ $check_president_id->dob ? \Carbon\Carbon::parse($check_president_id->dob)->format('d/m/Y') : 'তথ্য নেই' }}"
                                disabled>
                        </div>
                        <!-- Age -->
                        <div class="col-md-6 mt-4">
                            <label for="presidentAge" class="form-label"><strong>বয়স (Age)</strong></label>
                            <input type="text" class="form-control border-0 text-dark" id="presidentAge"
                                value="{{ $check_president_id->dob ? \Carbon\Carbon::parse($check_president_id->dob)->age . ' years old' : 'তথ্য নেই' }}"
                                disabled>
                        </div>
                        <!-- NID -->
                        <div class="col-md-6 mt-4">
                            <label for="presidentNID" class="form-label"><strong>জাতীয় পরিচয়পত্র নং (NID
                                    No.)</strong></label>
                            <input type="text" class="form-control border-0 text-dark" id="presidentNID"
                                value="{{ $check_president_id->nid ?? 'তথ্য নেই' }}" disabled>
                        </div>
                        <!-- Phone -->
                        <div class="col-md-6 mt-4">
                            <label for="presidentPhone" class="form-label"><strong>ফোন নম্বর (Phone)</strong></label>
                            <input type="text" class="form-control border-0 text-dark" id="presidentPhone"
                                value="{{ $check_president_id->phone ?? 'তথ্য নেই' }}" disabled>
                        </div>
                        <!-- Email -->
                        <div class="col-md-6 mt-4">
                            <label for="presidentEmail" class="form-label"><strong>ইমেইল (Email)</strong></label>
                            <input type="text" class="form-control border-0 text-dark" id="presidentEmail"
                                value="{{ $check_president_id->email ?? 'তথ্য নেই' }}" disabled>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Secretary Information -->
            <div class="col-md-6 pr-0 pl-1">
                <div class="card mb-0 shadow-sm p-5">
                    <div class="row">
                        <!-- Image Section -->
                        <div class="col-md-12 text-center mb-4">
                            <img src="{{ uploaded_asset($check_secretary_id->image) }}" style="height: 180px; width:150px"
                                alt="Secretary's Image" class="rounded-circle">
                        </div>
                        <!-- Name Section -->
                        <div class="col-md-12 text-center">
                            <h6>{{ $check_secretary_id->name_bn ?? 'তথ্য নেই' }}</h6>
                            <h6>{{ $check_secretary_id->name_en ?? 'তথ্য নেই' }}</h6>
                        </div>
                        <!-- Birthdate -->
                        <div class="col-md-6 mt-4">
                            <label for="secretaryDOB" class="form-label"><strong>জন্ম তারিখ (Date of Birth)</strong></label>
                            <input type="text" class="form-control border-0 text-dark" id="secretaryDOB"
                                value="{{ $check_secretary_id->dob ? \Carbon\Carbon::parse($check_secretary_id->dob)->format('d/m/Y') : 'তথ্য নেই' }}"
                                disabled>
                        </div>
                        <!-- Age -->
                        <div class="col-md-6 mt-4">
                            <label for="secretaryAge" class="form-label"><strong>বয়স (Age)</strong></label>
                            <input type="text" class="form-control border-0 text-dark" id="secretaryAge"
                                value="{{ $check_secretary_id->dob ? \Carbon\Carbon::parse($check_secretary_id->dob)->age . ' years old' : 'তথ্য নেই' }}"
                                disabled>
                        </div>
                        <!-- NID -->
                        <div class="col-md-6 mt-4">
                            <label for="secretaryNID" class="form-label"><strong>জাতীয় পরিচয়পত্র নং (NID
                                    No.)</strong></label>
                            <input type="text" class="form-control border-0 text-dark" id="secretaryNID"
                                value="{{ $check_secretary_id->nid ?? 'তথ্য নেই' }}" disabled>
                        </div>
                        <!-- Phone -->
                        <div class="col-md-6 mt-4">
                            <label for="secretaryPhone" class="form-label"><strong>ফোন নম্বর (Phone)</strong></label>
                            <input type="text" class="form-control border-0 text-dark" id="secretaryPhone"
                                value="{{ $check_secretary_id->phone ?? 'তথ্য নেই' }}" disabled>
                        </div>
                        <!-- Email -->
                        <div class="col-md-6 mt-4">
                            <label for="secretaryEmail" class="form-label"><strong>ইমেইল (Email)</strong></label>
                            <input type="text" class="form-control border-0 text-dark" id="secretaryEmail"
                                value="{{ $check_secretary_id->email ?? 'তথ্য নেই' }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container bg-white border shadow rounded px-5 py-4 my-3">
        <h5 class="text-center ">ইংরেজিতে দক্ষ ব্যক্তির তথ্য</h5>
        <div class="mt-4">
            @if(empty($check_english_id->id))
                <div class="text-center text-muted border">
                    <span>ইংরেজিতে পারদর্শী কোন ব্যক্তি পাওয়া যায়নি</span>
                </div>
            @else
                <div class="row">
                    <div class="col-md-4 mt-4">
                        <label for="name" class="form-label"><strong>নাম (Name)</strong></label>
                        <input type="text" class="form-control border-0 text-dark" id="name"
                            value="{{ $check_english_id->name_en ?? 'তথ্য নেই' }}" disabled>
                    </div>
                    <div class="col-md-4 mt-4">
                        <label for="designation" class="form-label"><strong>পদবি (Designation)</strong></label>
                        <input type="text" class="form-control border-0 text-dark" id="designation"
                            value="{{ $check_english_id->designation ?? 'তথ্য নেই' }}" disabled>
                    </div>
                    <div class="col-md-4 mt-4">
                        <label for="dob" class="form-label"><strong>জন্ম তারিখ (Date of Birth)</strong></label>
                        <input type="text" class="form-control border-0 text-dark" id="dob"
                            value="{{ $check_english_id->dob ? \Carbon\Carbon::parse($check_english_id->dob)->format('d/m/Y') : 'তথ্য নেই' }}"
                            disabled>
                    </div>
                    <div class="col-md-4 mt-4">
                        <label for="nid" class="form-label"><strong>জাতীয় পরিচয়পত্র নং (NID No.)</strong></label>
                        <input type="text" class="form-control border-0 text-dark" id="nid"
                            value="{{ $check_english_id->nid ?? 'তথ্য নেই' }}" disabled>
                    </div>
                    <div class="col-md-4 mt-4">
                        <label for="phone" class="form-label"><strong>ফোন নম্বর (Phone)</strong></label>
                        <input type="text" class="form-control border-0 text-dark" id="phone"
                            value="{{ $check_english_id->phone ?? 'তথ্য নেই' }}" disabled>
                    </div>
                    <div class="col-md-4 mt-4">
                        <label for="email" class="form-label"><strong>ইমেইল (Email)</strong></label>
                        <input type="text" class="form-control border-0 text-dark" id="email"
                            value="{{ $check_english_id->email ?? 'তথ্য নেই' }}" disabled>
                    </div>
                </div>

            @endif
        </div>
    </div>

    <div class="container bg-white border shadow rounded px-5 py-4 my-3">
        <h5 class="text-center ">ব্যাংকের তথ্য (Bank Details)</h5>
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead class="fw-600">
                    <tr>
                        <th>ব্যাংকের নাম (Bank Name)</th>
                        <th>শাখার নাম (Branch Name)</th>
                        <th>হিসাব নাম (Account Name)</th>
                        <th>হিসাব নং (Account Number)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banks as $bank)
                        <tr>
                            <td>{{ $bank->bank_name ?? 'Not available' }}</td>
                            <td>{{ $bank->branch_name ?? 'Not available' }}</td>
                            <td>{{ $bank->account_name ?? 'Not available' }}</td>
                            <td>{{ $bank->account_number ?? 'Not available' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="container bg-white border shadow rounded px-5 py-4 my-3">
        <h5 class="text-center ">সংগঠনের কর্মপরিকল্পনা (Organization's Activity)</h5>
        <div class="row">
            <div class="col-md-6 my-3 d-flex gutter-none">

                @if($organization_activity->objectives_doc)
                    <div class="col-md-9 px-0">
                        <strong>লক্ষ্য ও উদ্দেশ্য (Objectives)</strong>
                        <p class="border rounded  p-2 overflow_text">
                            {{$organization_activity->objectives}}
                        </p>
                    </div>
                    <div class="col-md-3">
                        <span>সংযুক্তি</span>
                        <a href="{{ uploaded_asset($organization_activity->objectives_doc) }}" target="_blank">
                            <img src="{{ static_asset('assets/img/pdf-icon.png') }}" alt="PDF Thumbnail" width="100"
                                height="90">
                        </a>
                    </div>
                @else
                    <div class="col-md-12 px-0">
                        <strong>লক্ষ্য ও উদ্দেশ্য (Objectives)</strong>
                        <p class="border rounded  p-2 overflow_text">
                            {{$organization_activity->objectives}}
                        </p>
                    </div>
                @endif

            </div>
            <div class="col-md-6 my-3 d-flex">
                @if($organization_activity->plan_doc)
                    <div class="col-md-9 px-0">
                        <strong>কর্মপরিকল্পনা (Plannings)</strong>
                        <p class="border rounded p-2 overflow_text">{{$organization_activity->plan}}</p>
                    </div>
                    <div class="col-md-3 mt-4">
                        <span>সংযুক্তি</span>
                        <a href="{{ uploaded_asset($organization_activity->plan_doc) }}" target="_blank">
                            <img src="{{ static_asset('assets/img/pdf-icon.png') }}" alt="PDF Thumbnail" width="100"
                                height="90">
                        </a>
                    </div>
                @else
                    <div class="col-md-12 px-0">
                        <strong>কর্মপরিকল্পনা (Plannings)</strong>
                        <p class="border rounded p-2 overflow_text">{{$organization_activity->plan}}</p>
                    </div>
                @endif
            </div>
        </div>
        <h6 class="mt-2">বিগত সাধারন সভা যে তারিখে অনুষ্ঠিত হইয়াছে সেই তারিখের তথ্য</h6>
        <div class="col-md-12 mt-4">
            <div class="card shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Meeting Date and Total Members -->
                    <div class="d-flex flex-column">
                        <p class="mb-2"><strong>তারিখ :</strong> {{ $organization_activity->last_meeting_date }}</p>
                    </div>
                    <div class="d-flex flex-column">
                        <p><strong>মোট সদস্য সংখ্যা :</strong> {{ $organization_activity->total_members_last_meeting }}</p>
                    </div>
                    <!-- Document Section -->
                    <div class="d-flex align-items-center">
                        <strong class="mr-3">কার্যবিবরণীর অনুলিপি:</strong>
                        @if($organization_activity->members_opinion_doc)
                            <a href="{{ uploaded_asset($organization_activity->members_opinion_doc) }}" target="_blank">
                                <img src="{{ static_asset('assets/img/pdf-icon.png') }}" alt="PDF Thumbnail" class="img-fluid"
                                    style="width: 60px; height: 60px; object-fit: cover;">
                            </a>
                        @else
                            <span>ফাইল নেই</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="container border bg-white shadow rounded px-5 py-4 my-3">
        <h5 class="text-center ">পুরষ্কার এবং অর্জনসমূহ (Awards & Achievements)</h5>
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead class="fw-600">
                    <tr>
                        <th>Type</th>
                        <th>Award Title</th>
                        <th>From Organization</th>
                        <th>Received Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if($organization_award->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center">No awards available</td>
                        </tr>
                    @else
                        @foreach($organization_award as $award)
                            <tr>
                                <td>{{ ucfirst($award->type) ?? 'Not available' }}</td>
                                <td>{{ $award->award_tittle ?? 'Not available' }}</td>
                                <td>{{ $award->from_organization ?? 'Not available' }}</td>
                                <td>{{ $award->recieve_date ? \Carbon\Carbon::parse($award->recieve_date)->format('d/m/Y') : 'Not available' }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="container border bg-white shadow rounded px-5 py-4 my-3">
        <h5 class="text-center ">অনুদান এবং সাহায্য (Grants & Aids)</h5>
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead class="fw-600">
                    <tr>
                        <th>Grant Details</th>
                        <th>From Organization</th>
                        <th>Received Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if($organization_grant->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center">No grants available</td>
                        </tr>
                    @else
                        @foreach($organization_grant as $grant)
                            <tr>
                                <td>{{ $grant->grant_detail ?? 'Not available' }}</td>
                                <td>{{ $grant->from_organization ?? 'Not available' }}</td>
                                <td>{{ $grant->recieve_date ? \Carbon\Carbon::parse($grant->recieve_date)->format('d/m/Y') : 'Not available' }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="container border bg-white shadow rounded px-5 pt-4 my-3 fw-600">
        <h5 class="text-center ">কাজের ক্ষেত্র সমুহ (Domains Of Work)</h5>
        <div class="row container my-4 mx-auto">

            <ol class="row">
                @foreach($domains as $domain)
                    @if(in_array($domain->id, $domains_id))
                        <li class="col-md-4 fw-400"><span class="fw-500">{{$domain->name}}</span></li>
                    @endif
                @endforeach
            </ol>
            <!-- Others Option -->
            <div class="col-md-4 my-1">
                @if($other)
                    <ul>
                        <li>Others: <p class="border rounded  p-2 overflow_text">{{$other}}</p>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </div>



    <div class="container bg-white border shadow rounded px-5 py-4 my-3 fw-600">
        <h5 class="text-center my-3">কাজের ক্ষেত্র সমুহ (Domains Of Work)</h5>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4 my-4">
                <div class="document-item card shadow-md border-light">
                    <div class="card-body text-center">
                        <label for="challan" class="d-block font-weight-bold">
                            <span>(পাঁচশত) টাকার ট্রেজারি চালানের কপি (Copy of treasury challan)</span>
                        </label>
                        <a href="{{ uploaded_asset($documents->challan) }}" target="_blank">
                            <img src="{{ static_asset('assets/img/pdf-icon.png') }}" alt="PDF Thumbnail" width="80"
                                height="80">
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 my-4">
                <div class="document-item card shadow-md border-light">
                    <div class="card-body text-center">
                        <label for="constitution" class="d-block font-weight-bold">
                            <span>সংগঠন নিবন্ধনের নথিপত্র (Organization registration documents)</span>
                        </label>
                        <a href="{{ uploaded_asset($documents->reg_doc) }}" target="_blank">
                            <img src="{{ static_asset('assets/img/pdf-icon.png') }}" alt="PDF Thumbnail" width="80"
                                height="80">
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 my-4">
                <div class="document-item card shadow-md border-light">
                    <div class="card-body text-center">
                        <label for="constitution" class="d-block font-weight-bold">
                            <span>সংগঠনের গঠনতন্ত্রের অনুলিপি (Copy of Organization's constitution)</span>
                        </label>
                        <a href="{{ uploaded_asset($documents->constitution) }}" target="_blank">
                            <img src="{{ static_asset('assets/img/pdf-icon.png') }}" alt="PDF Thumbnail" width="80"
                                height="80">
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <div class="document-item card shadow-md border-light">
                    <div class="card-body text-center">
                        <label for="general_members" class="d-block font-weight-bold">
                            <span>সাধারণ সদস্যদের নামের তালিকা (List of names of general members)</span>
                        </label>
                        <a href="{{ $documents->general_members }}" target="_blank">
                            <img src="{{ static_asset('assets/img/pdf-icon.png') }}" alt="PDF Thumbnail" width="80"
                                height="80">
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <div class="document-item card shadow-md border-light">
                    <div class="card-body text-center">
                        <label for="council_members" class="d-block font-weight-bold">
                            <span>কার্যনির্বাহী পরিষদের সদস্যদের তালিকা (List of Executive Council members)</span>
                        </label>
                        <a href="{{ $documents->council_members }}" target="_blank">
                            <img src="{{ static_asset('assets/img/pdf-icon.png') }}" alt="PDF Thumbnail" width="80"
                                height="80">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if ($org_details->status == 1)
        <div class="container bg-white border shadow rounded px-5 py-4 my-3 fw-600">
            <div class="text-center">
                @can('approve_submission')
                    <a class="btn btn-success btn-lg confirm-approve px-5 py-3 m-3" href="javascript:void(0);"
                        data-href="{{ route('organizations.approve', $organization->id) }}" title="{{ translate('Approve') }}">
                        <i class="las la-check-square"> </i>Approve
                    </a>
                @endcan
                @can('reject_submission')
                    <a class="btn btn-danger btn-lg confirm-reject px-5 py-3 m-3" href="javascript:void(0);"
                        data-href="{{ route('organizations.reject', $organization->id) }}" title="{{ translate('Reject') }}">
                        <i class="las la-times"></i> Reject
                    </a>
                @endcan
            </div>
        </div>
    @elseif ($org_details->status == 2)
        <div class="container bg-success rounded px-5 py-4 my-3 fw-600">
            <div class="text-center text-light fs-4">
                <i class="las la-check"></i> {{ translate('Approved') }}
            </div>
        </div>
    @elseif ($org_details->status == 3)
        <div class="container bg-danger rounded px-5 py-4 my-3 fw-600">
            <div class="text-center text-light fs-4">
                <i class="las la-times"></i> {{ translate('Rejected') }}
            </div>
        </div>
    @endif



@endsection

@section('modal')
    @include('modals.approve_modal')
    @include('modals.reject_modal')
@endsection