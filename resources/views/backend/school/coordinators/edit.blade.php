<form action="{{ route('coordinators.update', ['id' => $coordinator->id, 'school_id' => $school_id]) }}" method="POST" onsubmit="return validatePassword()">
    @csrf
    <div class="text-dark border rounded p-4 shadow-sm" style="border-radius: 20px!important;">
        <div class="w-100">
            <div class="form-row">
                <input type="hidden"  name="school_id" id="name" value="{{ $schools->first()->id }}">
                <div class="form-group col-md-4">
                    <label class="from-label fs-13" for="role_id">{{translate('Role')}} <span class="text-danger">*</span></label>
                    <select name="role_id" id="role_id" class="form-control aiz-selectpicker" onchange="coordinatorRoleSelect(this.value)" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" @selected($role->id == $coordinator->userrole->role_id)>{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-4" @if($coordinator->campus_id == null) style="display: none;" @endif>
                    <label class="from-label fs-13" for="campus_id">{{translate('Campus')}}</label>
                    <div class="">
                        <select name="campus_id" id="campus_id" class="form-control aiz-selectpicker" onchange="shiftWiseClassForScheduleCreate(this.value)">
                            <option value="">Select a campus</option>
                            @foreach($campuses as $campus)
                            <option value="{{ $campus->id }}" @selected($campus->id == $coordinator->campus_id)>{{ $campus->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-4" @if($coordinator->shift_id == null) style="display: none;" @endif>
                    <label class="from-label fs-13" for="shift_id">{{translate('Shift')}}</label>
                    <div class="">
                        <select name="shift_id" id="shift_id" class="form-control aiz-selectpicker" onchange="shiftWiseClassForScheduleCreate(this.value)">
                            <option value="">Select a shift</option>
                            @foreach($shifts as $shift)
                            <option value="{{ $shift->id }}" @selected($shift->id == $coordinator->shift_id)>{{ $shift->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-4" @if($coordinator->class_id == null) style="display: none;" @endif>
                    <label class="from-label fs-13" for="class_id">{{translate('Class')}} <span class="text-danger">*</span></label>
                    <div class="">
                        <select name="class_id" id="class_id" class="form-control aiz-selectpicker" onchange="classWiseSectionForScheduleCreate(this.value)" required>
                            <option value="">Select a class</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}" @selected($class->id == $coordinator->class_id)>{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-4" @if($coordinator->section_id == null) style="display: none;" @endif>
                    <label class="from-label fs-13" for="section_id">{{translate('Section')}}</label>
                    <div class="">
                        <select name="section_id" id="section_id" class="form-control aiz-selectpicker">
                            <option value="">Select a section</option>
                            @foreach($sections as $section)
                            <option value="{{ $section->id }}" @selected($section->id == $coordinator->section_id)>{{ $section->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Information -->
    <div class="text-dark my-2 border rounded p-4 shadow-sm" style="border-radius: 20px!important;">
        <h5 class="mb-3 pb-3 pt-3 fs-15 fw-700" style="border-bottom: 1px dashed #e4e5eb;">{{translate('Information of the Co-ordinator')}}</h5>
        <div class="w-100">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label class="from-label" for="name">{{ translate('Name') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $coordinator->user->name }}" placeholder="{{ translate('Name') }}" required>
                </div>

                <div class="form-group col-md-4">
                    <label class="from-label" for="phone">{{ translate('Phone') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="phone" id="phone" value="{{ $coordinator->user->phone }}" placeholder="{{ translate('Phone') }}" required>
                </div>

                <div class="form-group col-md-4">
                    <label class="from-label" for="email">{{translate('Email Address')}} <span class="text-danger">*</span></label>
                    <input type="email" placeholder="{{ translate('Email Address') }}" value="{{ $coordinator->user->email }}" class="form-control @error('email') is-invalid @enderror" name="email" id="email" required>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group mb-3 text-right">
        <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
    </div>
</form>

<!-- Custom Error Message -->
<div id="password-error" class="alert alert-danger" style="display: none; margin-top: 15px; border-radius: 10px;">
    <strong>{{ translate('Error!') }}</strong> {{ translate('Passwords do not match. Please try again.') }}
</div>

<script type="text/javascript">
    function validatePassword() {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('password_confirmation').value;
        
        if (password !== confirmPassword) {
            // Show custom error message
            document.getElementById('password-error').style.display = 'block';
            return false; // Prevent form submission
        }

        // Hide the error message if passwords match
        document.getElementById('password-error').style.display = 'none';
        return true;
    }

    function coordinatorRoleSelect(role_id) {
        if (role_id == 4) {
            $('#campus_id').closest('.form-group').show();
            $('#shift_id').closest('.form-group').show();
            $('#class_id').closest('.form-group').show();
            $('#section_id').closest('.form-group').show();
        } else {
            $('#campus_id').closest('.form-group').hide();
            $('#shift_id').closest('.form-group').hide();
            $('#class_id').closest('.form-group').hide();
            $('#section_id').closest('.form-group').hide();
        }
    }

    function schoolWiseCampusForScheduleCreate(school_id) {
        var role_id = $('#role_id').val();
        $.ajax({
            type: "GET",
            url: "{{ route('school-wise-campus', '') }}/" + school_id,
            success: function(response) {
                if (role_id == 4) {
                    $('#campus_id').closest('.form-group').show();
                    $('#campus_id').html(response);
                }
            }, error: function() {
                $('#campus_id').html('<option value="">Select campus</option>');
                $('#campus_id').closest('.form-group').hide();
            }
        });
    }

    function schoolWiseShiftForScheduleCreate(school_id) {
        var role_id = $('#role_id').val();
        $.ajax({
            type: "GET",
            url: "{{ route('school-wise-shift', '') }}/" + school_id,
            success: function(response) {
                if (role_id == 4) {
                    $('#shift_id').closest('.form-group').show();
                    $('#shift_id').html(response);
                }
            }, error: function() {
                $('#campus_id').html('<option value="">Select shift</option>');
                $('#shift_id').closest('.form-group').hide();
            }
        });
    }

    function schoolWiseClassForScheduleCreate(school_id) {
        var role_id = $('#role_id').val();
        schoolWiseShiftForScheduleCreate(school_id);
        schoolWiseCampusForScheduleCreate(school_id);
        $.ajax({
            type: "GET",
            url: "{{ route('school-wise-class', '') }}/" + school_id,
            success: function(response) {
                if (role_id == 4) {
                    $('#class_id').closest('.form-group').show();
                    $('#class_id').html(response);
                }
            }, error: function() {
                $('#class_id').html('<option value="">Select class</option>');
                $('#class_id').closest('.form-group').hide();
                $('#section_id').closest('.form-group').hide();
            }
        });
    }

    function classWiseSectionForScheduleCreate(class_id) {
        var role_id = $('#role_id').val();
        $.ajax({
            type: "GET",
            url: "{{ route('class-wise-section', '') }}/" + class_id,
            success: function(response) {
                if (role_id == 4) {
                    $('#section_id').closest('.form-group').show();
                    $('#section_id').html(response);
                }
            }, error: function() {
                $('#campus_id').html('<option value="">Select section</option>');
                $('#section_id').closest('.form-group').hide();
            }
        });
    }
</script>
