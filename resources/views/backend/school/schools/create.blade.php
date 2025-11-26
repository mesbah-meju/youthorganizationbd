<form class="form-horizontal" action="{{ route('schools.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="w-100">
        <div class="form-row text-dark bg-light border rounded p-2 shadow-sm" style="border-radius: 20px!important;">

            <div class="form-group col-md-4">
                <label class="from-label" for="division_id">{{ translate('Division') }} <span class="text-danger">*</span></label>
                <select name="division_id" id="division_id" class="form-control aiz-selectpicker" onchange="divisionWiseDistrictForSchoolCreate(this.value)">
                    <option value="">Select a division</option>
                    @foreach($divisions as $division)
                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-4">
                <label class="from-label" for="district_id">{{ translate('District') }} <span class="text-danger">*</span></label>
                <select name="district_id" id="district_id" class="form-control aiz-selectpicker" onchange="districtWiseUpazilaForSchoolCreate(this.value)">
                    <option value="">Select district</option>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label class="from-label" for="school">{{ translate('Upazila') }} <span class="text-danger">*</span></label>
                <select name="upazila_id" id="upazila_id" class="form-control aiz-selectpicker">
                    <option value="">Select upazila</option>
                </select>
            </div>

            <div class="form-group col-md-8">
                <label class="from-label" for="school_name">{{ translate('School Name') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="school_name" id="school_name" placeholder="{{ translate('School Name') }}" required>
            </div>
            <div class="form-group col-md-4">
                <label class="from-label" for="established">{{ translate('Established') }} <span class="text-danger">*</span></label>
                <select class="form-control yearpicker" name="established" id="established" required>
                    <option value="" disabled selected>{{ translate('Select Year') }}</option>
                </select>
            </div>

            <div class="form-group col-md-12">
                <label class="from-label" for="address">{{ translate('Address') }} <span class="text-danger">*</span></label>
                <textarea class="form-control" name="address" id="address" placeholder="{{ translate('Address') }}" rows="3" required></textarea>
            </div>
        </div>
    </div>

    <!-- Principal Information -->
    <div class="text-dark bg-light border rounded p-2 shadow-sm my-2" style="border-radius: 20px!important;">
        <h5 class="mb-3 pb-3 pt-3 fs-15 fw-700" style="border-bottom: 1px dashed #e4e5eb;">{{translate('Information of the Principal')}}</h5>
        <div class="w-100">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label class="from-label" for="principal_name">{{ translate('Name of the Principal') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control principal-field" name="principal_name" id="principal_name" placeholder="{{ translate('Name') }}" required>
                </div>
        
                <div class="form-group col-md-4">
                    <label class="from-label" for="principal_contact">{{ translate('Contact No.') }} <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="tel" class="form-control principal-field phone-field" name="principal_contact" id="principal_contact" required>
                    </div>
                    <small class="phone-error text-danger" style="display: none;">Please enter a valid phone number.</small>
                </div>
                
                
                <div class="form-group col-md-4">
                    <label class="from-label" for="principal_email">{{ translate('Email Address') }} <span class="text-danger">*</span></label>
                    <input type="email" class="form-control principal-field email-field" name="principal_email" id="principal_email" placeholder="{{ translate('Email Address') }}" required>
                    <small class="email-error text-danger" style="display: none;">Please enter a valid email address.</small>
                </div>
        
            </div>
        </div>
    </div>
    
    <!-- Focal Person Information -->
    <div class="text-dark bg-light border rounded p-2 shadow-sm my-2" style="border-radius: 20px!important;">
        <h5 class="mb-3 pb-3 pt-3 fs-15 fw-700" style="border-bottom: 1px dashed #e4e5eb;">{{translate('Information of Focal Person')}}</h5>
        <div class="w-100">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label class="from-label" for="focal_person_name">{{ translate('Name of Focal Person') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control focal-person-field" name="focal_person_name" id="focal_person_name" placeholder="{{ translate('Name') }}" required>
                </div>
        
                <div class="form-group col-md-4">
                    <label class="from-label" for="focal_person_contact">{{ translate('Contact No.') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control focal-person-field phone-field" name="focal_person_contact" id="focal_person_contact"  required>
                    <small class="phone-error text-danger" style="display: none;">Please enter a valid phone number.</small>
                </div>
        
                <div class="form-group col-md-4">
                    <label class="from-label" for="focal_person_email">{{ translate('Email Address') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control focal-person-field email-field" name="focal_person_email" id="focal_person_email" placeholder="{{ translate('Email Address') }}" required>
                    <small class="email-error text-danger" style="display: none;">Please enter a valid email address.</small>
                </div>
            </div>
        </div> 
    </div> 
    
    <div class="form-group mb-3 text-right">
        <button type="submit" class="btn btn-success">{{translate('Save')}}</button>
    </div>
</form>

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
                $('#district_id').html(response);
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

<script>
    // Phone number validation function
    function validatePhone(inputElement) {
        var phoneError = inputElement.parentElement.querySelector('.phone-error');
        
        // Regular expression for phone number validation: 
        // - Matches both formats: +8801925532372 and 01925532372
        var phonePattern = /^(?:\+880|1)\d{9}$/;
    
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

 

<!-- JavaScript to Initialize intl-tel-input -->

<script>
    const phoneFields = document.querySelectorAll("#principal_contact, #focal_person_contact");

    phoneFields.forEach((phoneField) => {
        const phoneInput = window.intlTelInput(phoneField, {
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            preferredCountries: ['bd', 'np'], // Bangladesh and Nepal
            separateDialCode: true, // Show country code separately
        });

        // Add an event listener to the form submit event
        const form = phoneField.closest("form");
        form.addEventListener("submit", function (e) {
            // Get the selected country data
            const countryData = phoneInput.getSelectedCountryData();
            const countryCode = `+${countryData.dialCode}`;
            let phoneNumber = phoneField.value.trim();

            // Ensure the phone number includes the country code
            if (!phoneNumber.startsWith(countryCode)) {
                phoneNumber = `${countryCode}${phoneNumber}`;
            }

            // Update the input field value with the full number
            phoneField.value = phoneNumber;

            // Validate the phone number length and format
            const phoneError = phoneField.closest('.form-group').querySelector('.phone-error');
            if (!phoneInput.isValidNumber()) {
                e.preventDefault(); // Stop the form from submitting

                // Display error based on country-specific validation
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

                // Set the error message text and display it
                phoneError.textContent = errorMessage;
                phoneError.style.display = 'block';

                // Focus the invalid field
                phoneField.focus();
            } else {
                // Hide the error message if valid
                phoneError.style.display = 'none';
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        // Set the starting year to 1700
        const startYear = 1700;
        const endYear = new Date().getFullYear();
        const selectedYear = ""; 
        
        let options = '<option value="" disabled>{{ translate("Select Year") }}</option>';
        for (let year = endYear; year >= startYear; year--) {
            if (year == selectedYear) {
                options += `<option value="${year}" selected>${year}</option>`;
            } else {
                options += `<option value="${year}">${year}</option>`;
            }
        }
        
        $('#established').html(options);

        // Initialize Select2
        $('.yearpicker').select2({
            placeholder: "{{ translate('Select Year') }}",
            allowClear: true,
            width: '100%'
        });
    });
</script>

 

{{-- <script>
    const phoneInputField = document.querySelector("#principal_contact");

    const phoneInput = window.intlTelInput(phoneInputField, {
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        preferredCountries: ['bd', 'np'], // Bangladesh and Nepal
        separateDialCode: true, // Show country code separately
    });

    // Add an event listener to the form submit event
    const form = phoneInputField.closest("form"); // Use closest form containing this field
    form.addEventListener("submit", function (e) {
        // Get the selected country code
        const countryData = phoneInput.getSelectedCountryData();
        const countryCode = `+${countryData.dialCode}`;
        let phoneNumber = phoneInputField.value.trim();

        // Check if the phone number already includes the country code
        if (!phoneNumber.startsWith(countryCode)) {
            phoneNumber = `${countryCode}${phoneNumber}`;
        }

        // Update the input field value with the full number
        phoneInputField.value = phoneNumber;

        // Validate the phone number
        if (!phoneInput.isValidNumber()) {
            e.preventDefault(); // Stop the form from submitting
            document.querySelector('.phone-error').style.display = 'block';
        } else {
            document.querySelector('.phone-error').style.display = 'none';
        }
    });

    // Add input event to hide error when the user corrects the phone number
    phoneInputField.addEventListener("input", () => {
        document.querySelector('.phone-error').style.display = 'none';
    });
</script> --}}

