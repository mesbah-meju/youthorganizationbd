@extends('backend.layouts.app')

@section('content')

<div class="col-lg-12 mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Add Student')}}</h5>
        </div>
        <form action="{{ route('students.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <!-- Student Information -->
                <h5 class="mb-3 pb-3 pt-3 fs-15 fw-700" style="border-bottom: 1px dashed #e4e5eb;">{{translate('Student Information')}}</h5>
                <div class="w-100">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="from-label" for="name">{{ translate('Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="{{ translate('Name') }}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label" for="roll">{{ translate('Roll') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="roll" id="roll" placeholder="{{ translate('Roll') }}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label" for="dob">{{ translate('Date Of Birth') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control datepicker" name="dob" id="dob" placeholder="{{ translate('Date Of Birth') }}" required>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="from-label" for="address">{{ translate('Address') }} <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="address" id="address" placeholder="{{ translate('Address') }}"></textarea>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label fs-13" for="school_id">{{translate('School')}} <span class="text-danger">*</span></label>
                            <div class="">
                                <select name="school_id" id="school_id" class="form-control aiz-selectpicker" onchange="schoolWiseClassForScheduleCreate(this.value)">
                                    <option value="">Select a school</option>
                                    @foreach($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label fs-13" for="shift_id">{{translate('Shift')}} <span class="text-danger">*</span></label>
                            <div class="">
                                <select name="shift_id" id="shift_id" class="form-control aiz-selectpicker" onchange="shiftWiseClassForScheduleCreate(this.value)">
                                    <option value="">Select shift</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label fs-13" for="class_id">{{translate('Class')}} <span class="text-danger">*</span></label>
                            <div class="">
                                <select name="class_id" id="class_id" class="form-control aiz-selectpicker" onchange="classWiseSectionForScheduleCreate(this.value)">
                                    <option value="">Select class</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label fs-13" for="section_id">{{translate('Section')}} <span class="text-danger">*</span></label>
                            <select name="section_id" id="section_id" class="form-control aiz-selectpicker">
                                <option value="">Select section</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label fs-13" for="user_type">{{translate('Who will be the primary user?')}} <span class="text-danger">*</span></label>
                            <select name="user_type" class="form-control aiz-selectpicker" id="user_type" required>
                                <option value="father">{{ translate('Father') }}</option>
                                <option value="mother">{{ translate('Mother') }}</option>
                                <option value="ecp">{{ translate('ECP') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Father Information -->
                <h5 class="mb-3 pb-3 pt-3 fs-15 fw-700" style="border-bottom: 1px dashed #e4e5eb;">{{translate('Father Information')}}</h5>
                <div class="w-100">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="from-label" for="father_name">{{ translate('Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="father_name" id="father_name" placeholder="{{ translate('Name') }}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label" for="father_email">{{ translate('Email Address') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="father_email" id="father_email" placeholder="{{ translate('Email Address') }}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label" for="father_contact_no">{{ translate('Contact No') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="father_contact_no" id="father_contact_no" placeholder="{{ translate('Contact No') }}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label" for="father_profession">{{ translate('Profession') }}</label>
                            <input type="text" class="form-control" name="father_profession" id="father_profession" placeholder="{{ translate('Profession') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label" for="father_dob">{{ translate('Date Of Birth') }}</label>
                            <input type="text" class="form-control datepicker" name="father_dob" id="father_dob" placeholder="{{ translate('Date Of Birth') }}">
                        </div>
                    </div>
                </div>

                <!-- Mother Information -->
                <h5 class="mb-3 pb-3 pt-3 fs-15 fw-700" style="border-bottom: 1px dashed #e4e5eb;">{{translate('Mother Information')}}</h5>
                <div class="w-100">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="from-label" for="mother_name">{{ translate('Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="mother_name" id="mother_name" placeholder="{{ translate('Name') }}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label" for="mother_email">{{ translate('Email Address') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="mother_email" id="mother_email" placeholder="{{ translate('Email Address') }}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label" for="mother_contact_no">{{ translate('Contact No') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="mother_contact_no" id="mother_contact_no" placeholder="{{ translate('Contact No') }}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label" for="mother_profession">{{ translate('Profession') }}</label>
                            <input type="text" class="form-control" name="mother_profession" id="mother_profession" placeholder="{{ translate('Profession') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label" for="mother_dob">{{ translate('Date of Birth') }}</label>
                            <input type="text" class="form-control datepicker" name="mother_dob" id="mother_dob" placeholder="{{ translate('Date Of Birth') }}">
                        </div>
                    </div>
                </div>

                <!-- Emergency Contact Information -->
                <h5 class="mb-3 pb-3 pt-3 fs-15 fw-700" style="border-bottom: 1px dashed #e4e5eb;">{{translate('Emergency Contact Information')}}</h5>
                <div class="w-100">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="from-label" for="ecp_name">{{ translate('Name') }}</label>
                            <input type="text" class="form-control" name="ecp_name" id="ecp_name" placeholder="{{ translate('Name') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label" for="ecp_email">{{ translate('Email Address') }}</label>
                            <input type="text" class="form-control" name="ecp_email" id="ecp_email" placeholder="{{ translate('Email Address') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label" for="ecp_contact_no">{{ translate('Contact No') }}</label>
                            <input type="text" class="form-control" name="ecp_contact_no" id="ecp_contact_no" placeholder="{{ translate('Contact No') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label" for="ecp_relationship">{{ translate('Relationship') }}</label>
                            <input type="text" class="form-control" name="ecp_relationship" id="ecp_relationship" placeholder="{{ translate('Relationship') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3 text-right">
                    <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    function schoolWiseShiftForScheduleCreate(school_id) {
        $.ajax({
            type: "GET",
            url: "{{ route('school-wise-shift', '') }}/" + school_id,
            success: function(response) {
                $('#shift_id').html(response);
            }
        });
    }

    function schoolWiseClassForScheduleCreate(school_id) {
        schoolWiseShiftForScheduleCreate(school_id);
        $.ajax({
            type: "GET",
            url: "{{ route('school-wise-class', '') }}/" + school_id,
            success: function(response) {
                $('#class_id').html(response);
            }
        });
    }

    function classWiseSectionForScheduleCreate(class_id) {
        $.ajax({
            type: "GET",
            url: "{{ route('class-wise-section', '') }}/" + class_id,
            success: function(response) {
                $('#section_id').html(response);
            }
        });
    }
</script>
@endsection
