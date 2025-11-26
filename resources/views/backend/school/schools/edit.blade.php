<form class="form-horizontal" action="{{ route('schools.update', $school->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="w-100">
        <div class="form-row text-dark bg-light border rounded p-2 shadow-sm" style="border-radius: 20px!important;">

            <div class="form-group col-md-4">
                <label class="from-label" for="division_id">{{ translate('Division') }} <span class="text-danger">*</span></label>
                <select name="division_id" id="division_id" class="form-control aiz-selectpicker" onchange="divisionWiseDistrictForSchoolCreate(this.value)" required>
                    <option value="">Select a division</option>
                    @foreach($divisions as $division)
                    <option value="{{ $division->id }}" @selected($school->division_id == $division->id)>{{ $division->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-4">
                <label class="from-label" for="district_id">{{ translate('District') }} <span class="text-danger">*</span></label>
                <select name="district_id" id="district_id" class="form-control aiz-selectpicker" onchange="districtWiseUpazilaForSchoolCreate(this.value)" required>
                    <option value="">Select a district</option>
                    @foreach($districts as $district)
                    <option value="{{ $district->id }}" @selected($school->district_id == $district->id)>{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-4">
                <label class="from-label" for="school">{{ translate('Upazila') }} <span class="text-danger">*</span></label>
                <select name="upazila_id" id="upazila_id" class="form-control aiz-selectpicker" required>
                    <option value="">Select a upazila</option>
                    @foreach($upazilas as $upazila)
                    <option value="{{ $upazila->id }}" @selected($school->upazila_id == $upazila->id)>{{ $upazila->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group col-md-8">
                <label class="from-label" for="school_name">{{ translate('School Name') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="school_name" id="school_name" value="{{ $school->name }}" placeholder="{{ translate('School Name') }}" required>
            </div>

           <div class="form-group col-md-4">
                <label class="from-label" for="established">{{ translate('Established') }} <span class="text-danger">*</span></label>
                <select class="form-control yearpicker" name="established" id="established" required>
                    <option value="" disabled>{{ translate('Select Year') }}</option>
                    @for ($year = date('Y'); $year >= 1900; $year--)
                        <option value="{{ $year }}" @if($school->established == $year) selected @endif>{{ $year }}</option>
                    @endfor
                </select>
            </div>
            

            {{-- <div class="form-group col-md-4">
                <label class="from-label" for="established">{{ translate('Established') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control yearpicker" name="established" id="established" value="{{ $school->established }}" placeholder="{{ translate('Established') }}" required>
            </div> --}}

            <div class="form-group col-md-12">
                <label class="from-label" for="address">
                    {{ translate('Address') }} <span class="text-danger">*</span>
                </label>
                <textarea class="form-control" name="address" id="address" rows="3" placeholder="{{ translate('Address') }}" required>{{ $school->address }}</textarea>
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
                    <input type="text" class="form-control" name="principal_name" id="principal_name" value="{{ $school->principal_name }}" placeholder="{{ translate('Name') }}" required>
                </div>

                <div class="form-group col-md-4">
                    <label class="from-label" for="principal_contact">{{ translate('Contact No.') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control  principal-field phone-field" name="principal_contact" id="principal_contact" value="{{ $school->principal_contact }}" placeholder="{{ translate('Contact No.') }}" required>
                    <small class="phone-error text-danger" style="display: none;">Please enter a valid phone number.</small>
                </div>

                <div class="form-group col-md-4">
                    <label class="from-label" for="principal_email">{{ translate('Email Address') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control principal-field email-field" name="principal_email" id="principal_email" value="{{ $school->principal_email }}" placeholder="{{ translate('Email Address') }}" required>
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
                    <input type="text" class="form-control" name="focal_person_name" id="focal_person_name" value="{{ $school->focal_person_name }}" placeholder="{{ translate('Name') }}" required>
                </div>

                <div class="form-group col-md-4">
                    <label class="from-label" for="focal_person_contact">{{ translate('Contact No.') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control focal-person-field phone-field" name="focal_person_contact" id="focal_person_contact" value="{{ $school->focal_person_contact }}" placeholder="{{ translate('Contact No.') }}" required>
                    <small class="phone-error text-danger" style="display: none;">Please enter a valid phone number.</small>
                </div>

                <div class="form-group col-md-4">
                    <label class="from-label" for="focal_person_email">{{ translate('Email Address') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control focal-person-field email-field" name="focal_person_email" id="focal_person_email" value="{{ $school->focal_person_email }}" placeholder="{{ translate('Email Address') }}" required>
                    <small class="email-error text-danger" style="display: none;">Please enter a valid email address.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group mb-3 text-right">
        <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
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
        $(document).ready(function () {
            // Generate years dynamically
            const startYear = 1750;
            const endYear = new Date().getFullYear();
            const selectedYear = "{{ $school->established }}"; // Pre-selected year from the database
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