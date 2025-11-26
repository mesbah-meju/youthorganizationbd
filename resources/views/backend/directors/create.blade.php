@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Director Information')}}</h5>
            </div>
            <form action="{{ route('directors.store') }}" method="POST" enctype="multipart/form-data">
            	@csrf
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="from-label" for="name">{{translate('Name')}} <span class="text-danger">*</span></label>
                            <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label class="from-label" for="email">{{translate('Email')}} <span class="text-danger">*</span></label>
                            <input type="email" placeholder="{{translate('Email')}}" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            @error('email')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label class="from-label" for="phone">{{translate('Phone')}} <span class="text-danger">*</span></label>
                            <input type="text" placeholder="{{translate('Phone')}}" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" required>
                            @error('phone')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label class="from-label" for="password">{{translate('Password')}} <span class="text-danger">*</span></label>
                            <input type="password" placeholder="{{translate('Password')}}" id="password" name="password" class="form-control" value="{{ old('password') }}" required>
                            @error('password')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label class="from-label" for="name">{{translate('Role')}} <span class="text-danger">*</span></label>
                            <select name="role_id" required class="form-control aiz-selectpicker">
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="from-label" for="division_id">{{ translate('Division') }} <span class="text-danger">*</span></label>
                            <select name="division_id" id="division_id" class="form-control aiz-selectpicker" onchange="divisionWiseDistrict(this.value)">
                                <option value="">Select a division</option>
                                @foreach($divisions as $division)
                                <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4" style="display: none;" id="district_div">
                            <label class="from-label" for="district_id">{{ translate('District') }} <span class="text-danger">*</span></label>
                            <select name="district_id" id="district_id" class="form-control aiz-selectpicker" onchange="districtWiseUpazila(this.value)" disabled>
                                <option value="">Select district</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4" style="display: none;" id="upazila_div">
                            <label class="from-label" for="school">{{ translate('Upazila') }} <span class="text-danger">*</span></label>
                            <select name="upazila_id" id="upazila_id" class="form-control aiz-selectpicker" disabled>
                                <option value="">Select upazila</option>
                            </select>
                        </div>
                        
                        <div class="form-group col-md-12">
                            <div class="mb-0 text-right">
                                <button type="submit" class="btn btn-sm btn-primary">{{translate('Submit')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    function divisionWiseDistrict(division_id) {
        $.ajax({
            type: "GET",
            url: "{{ route('division-wise-district', '') }}/" + division_id,
            success: function(response) {
                $('#district_id').html(response);
            }
        });
    }

    function districtWiseUpazila(district_id) {
        $.ajax({
            type: "GET",
            url: "{{ route('district-wise-upazila', '') }}/" + district_id,
            success: function(response) {
                $('#upazila_id').html(response);
            }
        });
    }

    function toggleLocationFields(roleId) {
        if (roleId == 5) {
            $('#district_div').show();
            $('#district_id').prop('disabled', false).attr('required', true);

            $('#upazila_div').hide();
            $('#upazila_id').prop('disabled', true).removeAttr('required').val('');
        } else if (roleId == 6) {
            $('#district_div').show();
            $('#upazila_div').show();

            $('#district_id').prop('disabled', false).attr('required', true);
            $('#upazila_id').prop('disabled', false).attr('required', true);
        } else {
            $('#district_div').hide();
            $('#upazila_div').hide();

            $('#district_id').prop('disabled', true).removeAttr('required').val('');
            $('#upazila_id').prop('disabled', true).removeAttr('required').val('');
        }

        // Refresh the select picker if you're using Bootstrap Select or AIZ selectpicker
        $('.aiz-selectpicker').selectpicker('refresh');
    }

    $(document).ready(function () {
        const initialRoleId = $('select[name="role_id"]').val();
        toggleLocationFields(initialRoleId);

        $('select[name="role_id"]').on('change', function () {
            toggleLocationFields($(this).val());
        });
    });
</script>
@endsection