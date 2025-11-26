<form class="form-horizontal" action="{{ route('campuses.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="w-100">
        <div class="form-row">
            {{-- <div class="form-group col-md-6">
                <label class="from-label fs-13" for="school_id">{{translate('School')}} <span class="text-danger">*</span></label>
                <div class="">
                    <select name="school_id" id="school_id" class="form-control aiz-selectpicker" onchange="schoolWiseClassForScheduleCreate(this.value)" required readonly>
                        <option value="">Select a school</option>
                        @foreach($schools as $school)
                            <option value="{{ $school->id }}" 
                                @if($school->id == $school_id) selected @endif>
                                {{ $school->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div> --}}
            <div class="form-group col-md-6">
                <label class="from-label" for="school_id">{{ translate('School Name') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control"  value="{{ $schools[0]->name }}" readonly>
                <input type="hidden" class="form-control" name="school_id" id="school_id" value="{{ $school_id }}" readonly>
            </div>

            <script>
                document.getElementById('school_id').addEventListener('mousedown', function(e) {
                    e.preventDefault(); 
                });
            </script>

            <div class="form-group col-md-6">
                <label class="from-label" for="campus_name">{{ translate('Campus Name') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="campus_name" id="campus_name" placeholder="{{ translate('Campus Name') }}" required>
            </div>

            <div class="form-group col-md-12">
                <label class="from-label" for="address">{{ translate('Address') }}</label>
                <textarea name="address" id="address" class="form-control" placeholder="{{ translate('Address') }}"></textarea>
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