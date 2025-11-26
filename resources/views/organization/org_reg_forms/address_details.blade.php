@extends('organization.layouts.app')

@section('panel_content')
    <div class="text-center mx-lg-5 mx-md-auto">
        <h4 class="bg-success text-white rounded py-3 px-2 mx-lg-5 mx-md-auto shadow-lg">
            Welcome to Youth Organization Database, Bangladesh
        </h4>
    </div>

    <!-- Form Container -->
    <div class="container bg-white border shadow rounded px-5 pt-4 my-5 fw-600">
        <h5 class="mb-4 text-center">যোগাযোগের মাধ্যম (Media of Communication)</h5>

        <form action="{{ route('organization.address.store') }}" method="POST">
            @csrf
            <h6 class="mt-4">সংগঠনের ঠিকানা (Organization Address)</h6>

            <div class="row">
                <div class="col-md-4 mt-3">
                    <label for="division_id" class="form-label">বিভাগ (Division)<span class="text-danger">*</span></label>
                    <select name="division_id" id="division_id" class="form-control aiz-selectpicker"
                        onchange="divisionWiseDistrictForSchoolCreate(this.value)" required>
                        <option value="">Select a division</option>
                        @foreach($divisions as $division)
                            <option value="{{ $division->id }}" {{ old('division_id', $org_address->division_id ?? '') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mt-3">
                    <label for="district_id" class="form-label">জেলা (District) <span class="text-danger">*</span></label>
                    <select class="form-control aiz-selectpicker" name="district_id" disabled id="district_id" required
                        onchange="districtWiseUpazilaForSchoolCreate(this.value)">
                        <option value="">Select District</option>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ old('district_id', $org_address->district_id ?? '') == $district->id ? 'selected' : '' }}>
                                {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mt-3">
                    <label for="upazila_id" class="form-label">উপজেলা (Sub-District)<span
                            class="text-danger">*</span></label>
                    <select class="form-control aiz-selectpicker" id="upazila_id" disabled required name="upazila_id">
                        <option value="">Select Sub-District</option>
                        @foreach($sub_districts as $subDistrict)
                            <option value="{{ $subDistrict->id }}" {{ old('upazila_id', $org_address->upazila_id ?? '') == $subDistrict->id ? 'selected' : '' }}>
                                {{ $subDistrict->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mt-3">
                    <label for="post_office_bn" class="form-label">ডাকঘর<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="post_office_bn" id="post_office_bn"
                        placeholder="ডাকঘর (বাংলায় লিখুন)"
                        value="{{ old('post_office_bn', $org_address->post_office_bn ?? '') }}" required>
                    @error('post_office_bn')
                        <div class="text-danger">Please insert in 'Bangla'</div>
                    @enderror
                </div>

                <div class="col-md-6 mt-3">
                    <label for="post_office_en" class="form-label">Post Office<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="post_office_en" id="post_office_en"
                        placeholder="Post Office (write in English)"
                        value="{{ old('post_office_en', $org_address->post_office_en ?? '') }}" required>
                    @error('post_office_en')
                        <div class="text-danger">Please insert in 'English'</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mt-3">
                    <label for="street_bn" class="form-label">সড়ক/ব্লক/সেক্টর <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="street_bn" name="street_bn"
                        placeholder="বাড়ি/গ্রাম/মহল্লা (বাংলায় লিখুন)"
                        value="{{ old('street_bn', $org_address->street_bn ?? '') }}" required>
                    @error('street_bn')
                        <div class="text-danger">Please insert in 'Bangla'</div>
                    @enderror
                </div>

                <div class="col-md-6 mt-3">
                    <label for="street_en" class="form-label">Road/Block/Sector <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="street_en" name="street_en"
                        placeholder="House/Village/Area (write in English)"
                        value="{{ old('street_en', $org_address->street_en ?? '') }}" required>
                    @error('street_en')
                        <div class="text-danger">Please insert in 'English'</div>
                    @enderror
                </div>

            </div>
            <div class="row">
                <div class="col-md-6 mt-3">
                    <label for="address_bn" class="form-label">বাড়ি/গ্রাম/মহল্লা<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="address_bn" id="address_bn"
                        placeholder="বাড়ি/গ্রাম/মহল্লা (বাংলায় লিখুন)"
                        value="{{ old('address_bn', $org_address->address_bn ?? '') }}" required>
                    @error('address_bn')
                        <div class="text-danger">Please insert in 'Bangla'</div>
                    @enderror
                </div>

                <div class="col-md-6 mt-3">
                    <label for="address_en" class="form-label">House/Village/Area<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="address_en" id="address_en"
                        placeholder="House/Village/Area (write in English)"
                        value="{{ old('address_en', $org_address->address_en ?? '') }}" required>
                    @error('address_en')
                        <div class="text-danger">Please insert in 'English'</div>
                    @enderror
                </div>
            </div>

            <h6 class="mt-5 ">যোগাযোগের তথ্য (Contact Information)</h6>
            <div class="row">
                <!-- Phone Number -->
                <div class="col-md-4 mt-3">
                    <label for="phone" class="form-label">ফোন নম্বর (Phone) <span class="text-danger">*</span></label>
                    <input type="text" pattern="[0-9]{11}" maxlength="11" class="form-control" name="phone" id="phone"
                        placeholder="ফোন নম্বর লিখুন" value="{{ old('phone', $org_address->phone ?? '') }}" required>
                    @error('phone')
                        <div class="text-danger">Please provide a valid phone number</div>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="col-md-4 mt-3">
                    <label for="email" class="form-label">ইমেইল (Email) <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="ইমেইল ঠিকানা লিখুন"
                        value="{{ old('email', $org_address->email ?? '') }}" required>
                    @error('email')
                        <div class="text-danger">Please provide a valid email address</div>
                    @enderror
                </div>

                <!-- Web Address -->
                <div class="col-md-4 mt-3">
                    <label for="web" class="form-label">ওয়েবসাইট (Website)</label>
                    <input type="text" class="form-control" name="website" id="web" placeholder="ওয়েবসাইটের লিংক লিখুন"
                        value="{{ old('website', $org_address->website ?? '') }}">
                    @error('website')
                        <div class="text-danger">Please provide a valid website URL</div>
                    @enderror
                </div>

            </div>

            <h6 class="mt-5">সামাজিক যোগাযোগ মাধ্যমের তথ্য (Social media Information)</h6>
            <div class="row">
                <!-- Facebook -->
                <div class="col-md-4 mt-3">
                    <label for="facebook" class="form-label">ফেসবুক (Facebook)</label>
                    <input type="text" class="form-control" name="facebook" id="facebook"
                        placeholder="ফেসবুক প্রোফাইল লিংক লিখুন"
                        value="{{ old('facebook', $org_address->facebook ?? '') }}">
                    @error('facebook')
                        <div class="text-danger">Please provide a valid Facebook link</div>
                    @enderror
                </div>

                <!-- LinkedIn -->
                <div class="col-md-4 mt-3">
                    <label for="linkedin" class="form-label">লিঙ্কডইন (LinkedIn)</label>
                    <input type="text" class="form-control" name="linkedin" id="linkedin"
                        placeholder="লিঙ্কডইন প্রোফাইল লিংক লিখুন"
                        value="{{ old('linkedin', $org_address->linkedin ?? '') }}">
                    @error('linkedin')
                        <div class="text-danger">Please provide a valid LinkedIn link</div>
                    @enderror
                </div>

                <!-- Twitter -->
                <div class="col-md-4 mt-3">
                    <label for="twitter" class="form-label">টুইটার (Twitter)</label>
                    <input type="text" class="form-control" name="twitter" id="twitter"
                        placeholder="টুইটার প্রোফাইল লিংক লিখুন" value="{{ old('twitter', $org_address->twitter ?? '') }}">
                    @error('twitter')
                        <div class="text-danger">Please provide a valid Twitter link</div>
                    @enderror
                </div>
            </div>


            <div class="row mt-5 mb-4 mx-auto justify-content-between">

                @if($org_details->status == 0)
                    <a class="btn btn-danger" href="{{ route('organization.details.create') }}"> Previous</a>
                @else
                    <a class="btn btn-danger" href="{{ route('organization.dashboard') }}"> Previous </a>
                @endif

                <button type="submit" class="btn btn-primary" onclick="enableSubDistrictBeforeSubmit()">Save & Go
                    Next</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function countryWiseDivisionForSchoolCreate(country_id) {
            $.ajax({
                type: "GET",
                url: "{{ route('country-wise-division', '') }}/" + country_id,
                success: function (response) {
                    $('#division_id').html(response);
                }
            });
        }

        function divisionWiseDistrictForSchoolCreate(division_id) {
            $.ajax({
                type: "GET",
                url: "{{ route('division-wise-district', '') }}/" + division_id,
                success: function (response) {
                    // #district will be enabled. otherwise diabled
                    $('#district_id').html(response);
                    $('#upazila_id').html('');
                    $('#district_id').prop('disabled', false);
                }
            });
        }

        function districtWiseUpazilaForSchoolCreate(district_id) {
            $.ajax({
                type: "GET",
                url: "{{ route('district-wise-upazila', '') }}/" + district_id,
                success: function (response) {
                    $('#upazila_id').html(response);
                    $('#upazila_id').prop('disabled', false);
                }
            });
        }

        function enableSubDistrictBeforeSubmit() {
            $('#district_id').prop('disabled', false);
            $('#upazila_id').prop('disabled', false);
        }
    </script>
@endsection