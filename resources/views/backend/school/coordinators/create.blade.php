<form id="coordinatorForm" action="{{ route('coordinators.store', $schools->first()->id) }}" method="POST">
    @csrf
    <div class="text-dark border rounded p-4 shadow-sm" style="border-radius: 20px!important;">
        <div class="w-100">
            <input type="hidden"  name="school_id" id="name" value="{{ $schools->first()->id }}">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="from-label" for="campus_id">{{ translate('Campus') }} <span class="text-danger">*</span></label>
                    <select required name="campus_id" id="campus_id" class="form-control aiz-selectpicker" onchange="campusWiseShiftForScheduleCreate(this.value)">
                        <option value="">Select a campus</option>
                        @foreach($campuses as $campus)
                            <option value="{{ $campus->id }}" {{ request('campus_id') == $campus->id ? 'selected' : '' }}>{{ $campus->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label class="from-label" for="shift_id">{{ translate('Shift') }} </label>
                    <select  name="shift_id" id="shift_id" class="form-control aiz-selectpicker" onchange="shiftWiseClassForScheduleCreate(this.value)">
                        <option value="">Select shift</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- User Information -->
    <div class="text-dark my-2 border rounded p-4 shadow-sm" style="border-radius: 20px!important;">
        <h5 class="mb-3 pb-3 pt-3 fs-15 fw-700" style="border-bottom: 1px dashed #e4e5eb;">{{translate('Information of Co-ordinator')}}</h5>
        <div class="w-100">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label class="from-label" for="class_id">{{ translate('Class') }} </label>
                    <select name="class_id" id="class_id" class="form-control aiz-selectpicker" onchange="classWiseSectionForScheduleCreate(this.value)">
                        <option value="">Select class</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label class="from-label" for="section_id">{{ translate('Section') }} </label>
                    <select name="section_id" id="section_id" class="form-control aiz-selectpicker">
                        <option value="">Select section</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label class="from-label fs-13" for="role_id">{{translate('Role')}} <span class="text-danger">*</span></label>
                    <select name="role_id" id="role_id" class="form-control aiz-selectpicker" onchange="coordinatorRoleSelect(this.value)" required>
                        @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label class="from-label" for="name">{{ translate('Name') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="{{ translate('Name') }}" required>
                </div>

                <div class="form-group col-md-4">
                    <label class="from-label" for="phone">{{ translate('Phone') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control co-field phone-field" name="phone" id="phone" placeholder="{{ translate('Phone') }}" required>
                    <small class="phone-error text-danger" style="display: none;">Please enter a valid phone number.</small>
                </div>

                <div class="form-group col-md-4">
                    <label class="from-label" for="email">{{translate('Email Address')}} <span class="text-danger">*</span></label>
                    <input type="email" placeholder="{{ translate('Email Address') }}" class="form-control co-field email-field @error('email') is-invalid @enderror" name="email" id="email" required>
                    <small class="email-error text-danger" style="display: none;">Please enter a valid email address.</small>
                </div>


            </div>
        </div>
    </div>

    <div class="form-group mb-3 text-right">
        <button type="button" id="saveButton" class="btn btn-primary">{{translate('Save')}}</button>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function () {
        $('#saveButton').click(function() {
            let formData = $('#coordinatorForm').serialize();
            let url = $('#coordinatorForm').attr('action');

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                success: function(response) {
                    $('#role_id').val('');
                    $('#class_id').val('');
                    $('#section_id').val('');
                    $('#name').val('');
                    $('#phone').val('');
                    $('#email').val('');

                    $('#table-coordinators').DataTable().ajax.reload();
                    AIZ.plugins.notify('success', response.message);
                },
                error: function(xhr) {
                    AIZ.plugins.notify('danger', response.message);
                }
            });
        });
    });

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

    // Dynamic dropdowns with Ajax
    function campusWiseShiftForScheduleCreate(school_id) {
        $.ajax({
            type: "GET",
            url: "{{ route('student.campus.wise.shift', '') }}/" + school_id,
            success: function(response) {
                $('#shift_id').html(response);
            }, 
            error: function() {
                $('#shift_id').html('<option value="">Select shift</option>');
            }
        });
    }

    function classWiseSectionForScheduleCreate(class_id) {
        if (class_id) {
            $.ajax({
                type: "GET",
                url: "{{ route('school.class-wise-sections', '') }}/" + class_id,
                success: function(response) {
                    $('#section_id').html(response.options);
                    $('#section_id').selectpicker('refresh'); // Refresh AizSelectPicker dropdown
                },
                error: function() {
                    alert("Failed to fetch sections. Please try again.");
                }
            });
        } else {
            $('#section_id').html('<option value="">Select section</option>');
            $('#section_id').selectpicker('refresh');
        }
    }

    function shiftWiseClassForScheduleCreate(shift_id) {
        if (shift_id) {
            $.ajax({
                type: "GET",
                url: "{{ route('school.shift-wise-class-find', '') }}/" + shift_id,
                success: function(response) {
                    $('#class_id').html(response.options);
                    $('#class_id').selectpicker('refresh');
                },
                error: function() {
                    alert("Failed to fetch classes. Please try again.");
                }
            });
        } else {
            $('#class_id').html('<option value="">Select class</option>');
            $('#class_id').selectpicker('refresh');
        }
    }


     // Phone number validation function
     function validatePhone(inputElement) {
        var phoneError = inputElement.parentElement.querySelector('.phone-error');
        
        // Regular expression for phone number validation: 
        // - Matches both formats: +8801925532372 and 01925532372
        var phonePattern = /^(?:\+880|01)\d{9}$/;
    
        if (phonePattern.test(inputElement.value)) {
            phoneError.style.display = 'none'; 
        } else {
            phoneError.style.display = 'block'; 
        }
    }
    
    // Email validation function
    function validateEmail(inputElement) {
        var emailError = inputElement.parentElement.querySelector('.email-error');
        
        // Basic email pattern
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        
        if (emailPattern.test(inputElement.value)) {
            emailError.style.display = 'none'; 
        } else {
            emailError.style.display = 'block';
        }
    }
    
    // Attach dynamic event listeners to phone and email fields
    document.querySelectorAll('.phone-field').forEach(function (phoneInput) {
        phoneInput.addEventListener('input', function () {
            validatePhone(phoneInput);
        });
    });
    
    document.querySelectorAll('.email-field').forEach(function (emailInput) {
        emailInput.addEventListener('input', function () {
            validateEmail(emailInput);
        });
    });
</script>

<script>
    const phoneFields = document.querySelectorAll("#phone");

    phoneFields.forEach((phoneField) => {
        const phoneInput = window.intlTelInput(phoneField, {
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            preferredCountries: ['bd', 'np'], 
            separateDialCode: true, 
        });

        const form = phoneField.closest("form");
        form.addEventListener("submit", function (e) {
            const countryData = phoneInput.getSelectedCountryData();
            const countryCode = `+${countryData.dialCode}`;
            let phoneNumber = phoneField.value.trim();

            if (!phoneNumber.startsWith(countryCode)) {
                phoneNumber = `${countryCode}${phoneNumber}`;
            }

            phoneField.value = phoneNumber;

            const phoneError = phoneField.closest('.form-group').querySelector('.phone-error');
            if (!phoneInput.isValidNumber()) {
                e.preventDefault();

                const errorType = phoneInput.getValidationError();
                let errorMessage = "Invalid phone number.";
                switch (errorType) {
                    case intlTelInputUtils.validationError.TOO_SHORT:
                        errorMessage = `Phone number is too short for ${countryData.name}.`;
                        break;
                    case intlTelInputUtils.validationError.TOO_LONG:
                        errorMessage = `Phone number is too long for ${countryData.name}.`;
                        break;
                    case intlTelInputUtils.validationError.INVALID_COUNTRY_CODE:
                        errorMessage = "Invalid country code.";
                        break;
                    case intlTelInputUtils.validationError.NOT_A_NUMBER:
                        errorMessage = "The input is not a valid number.";
                        break;
                }

                phoneError.textContent = errorMessage;
                phoneError.style.display = 'block';

                phoneField.focus();
            } else {
                phoneError.style.display = 'none';
            }
        });
    });
</script>