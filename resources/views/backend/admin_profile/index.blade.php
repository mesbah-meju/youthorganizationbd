@extends('backend.layouts.app')

@section('content')

<div class="col-lg-10 mx-auto">
    <div class="card p-4">
        <form class="form-horizontal" action="{{ route('profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
            <input name="_method" type="hidden" value="PATCH">
            @csrf
            <div class="d-flex">
                <div class="form-group col-md-12  mt-3">
                    <label class="col-from-label" for="name">{{translate('Name')}} <span class="text-danger">*</span></label>
                    <div class="">
                        <input type="text" class="form-control" placeholder="{{translate('Name')}}" name="name" value="{{ Auth::user()->name }}" required>
                        @error('name')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex">
                <div class="form-group col-md-6 mt-3">
                    <label class="col-from-label" for="phone">{{translate('Phone')}} <span class="text-danger">*</span></label>
                    <div class="">
                        <input type="text" class="form-control" placeholder="{{translate('phone')}}" name="phone" value="{{ Auth::user()->phone }}" required>
                        @error('phone')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-6 mt-3">
                    <label class="col-from-label" for="name">{{translate('Email')}} <span class="text-danger">*</span></label>
                    <div class="">
                        <input type="email" class="form-control" placeholder="{{translate('Email')}}" name="email" value="{{ Auth::user()->email }}">
                        @error('email')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex">
                <!-- new   -->
                <div class="form-group col-md-6 mt-3">
                    <label class="col-from-label" for="name">IBAS No.</label>
                    <div class="">
                        <input type="text" class="form-control" placeholder="Enter ID" name="gov_id" value="{{ Auth::user()->gov_id}}">
                    </div>
                </div>
                <div class="form-group col-md-6 mt-3">
                    <label class="col-from-label" for="name">Joining date at DYD</label>
                    <div class="">
                        <input type="date" class="form-control" name="joining_date" value="{{ Auth::user()->joining_date}}">
                    </div>
                </div>
            </div>

            <div class="d-flex">
                <div class="col-md-4 mt-3">
                    <label for="division_id" class="form-label">বিভাগ (Division) <span class="text-danger">*</span></label>
                    <select name="division_id" id="division_id" class="form-control aiz-selectpicker" onchange="divisionWiseDistrictForSchoolCreate(this.value)">
                        <option value="">Select a division</option>
                        @foreach($divisions as $division)
                        <option value="{{ $division->id }}" {{ old('division_id', Auth::user()->division ?? '') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mt-3">
                    <label for="district_id" class="form-label">জেলা (District)</label>
                    <select class="form-control aiz-selectpicker" name="district_id" id="district_id" onchange="districtWiseUpazilaForSchoolCreate(this.value)">
                        <option value="">Select District</option>
                        @foreach($districts as $district)
                        <option value="{{ $district->id }}" {{ old('district_id', Auth::user()->district ?? '') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mt-3">
                    <label for="upazila_id" class="form-label">উপজেলা (Upazila)</label>
                    <select class="form-control aiz-selectpicker" id="upazila_id" name="upazila_id">
                        <option value="">Select Upazila</option>
                        @foreach($upazilas as $upazila)
                        <option value="{{ $upazila->id }}" {{ old('upazila_id', Auth::user()->upazila ?? '') == $upazila->id ? 'selected' : '' }}>{{ $upazila->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="d-flex">
                <div class="form-group col-md-4 mt-3">
                    <label class="col-from-label" for="new_password">{{translate('New Password')}}</label>
                    <div class="">
                        <input type="password" class="form-control" placeholder="{{translate('New Password')}}" name="new_password">
                        @error('new_password')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-4 mt-3">
                    <label class="col-from-label" for="confirm_password">{{translate('Confirm Password')}}</label>
                    <div class="">
                        <input type="password" class="form-control" placeholder="{{translate('Confirm Password')}}" name="confirm_password">
                        @error('confirm_password')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex">
                <div class="form-group col-md-12 mt-3">
                    <label class="col-form-label" for="signinSrEmail">{{translate('Photo')}} <small>(90x90)</small></label>
                    <div>
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="avatar" class="selected-files" value="{{ Auth::user()->avatar_original }}">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mb-0 text-right">
                <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
            </div>
        </form>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
    function countryWiseDivisionForSchoolCreate(country_id) {
        $.ajax({
            type: "GET",
            url: "{{ route('country-wise-division', '') }}/" + country_id,
            success: function(response) {
                $('#division_id').html(response);
            }
        });
    }

    function divisionWiseDistrictForSchoolCreate(division_id) {
        $.ajax({
            type: "GET",
            url: "{{ route('division-wise-district', '') }}/" + division_id,
            success: function(response) {
                // #district will be enabled. otherwise diabled
                $('#district_id').html(response);
                $('#upazila_id').html('');
            }
        });
    }

    function districtWiseUpazilaForSchoolCreate(district_id) {
        $.ajax({
            type: "GET",
            url: "{{ route('district-wise-upazila', '') }}/" + district_id,
            success: function(response) {
                $('#upazila_id').html(response);
            }
        });
    }
</script>
@endsection