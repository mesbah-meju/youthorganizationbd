@extends('organization.layouts.app')

@section('panel_content')
    <div class="text-center mx-lg-5 mx-md-auto">
        <h4 class="bg-success text-white rounded py-3 px-2 mx-lg-5 mx-md-auto shadow-lg">
            Welcome to Youth Organization Database, Bangladesh
        </h4>
    </div>

    <div class="container border bg-white shadow rounded px-3 py-4 my-5 fw-600">
        <h5 class="text-center text-decoration-underlined">সদস্যগণের তথ্য (Members's Information)</h5>
        <form class="pt-4" action="{{ route('organization.members.store') }}" method="POST">
            @csrf

            <div class="row d-flex">
                <div class="col-md-6 pl-4 pb-4 border-right">
                    <div class="row">
                        <div class="col-md-6 mt-4 ">
                            <label for="presidentNameBangla" class="form-label">সভাপতির নাম <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="presidentNameBangla" name="presidentNameBangla"
                                placeholder="সভাপতির নাম (বাংলায় লিখুন)"
                                value="{{old('presidentNameBangla', $check_president_id->name_bn ?? '')}}" required>
                        </div>
                        <div class="col-md-6 mt-4">
                            <label for="presidentNameEnglish" class="form-label">President's Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="presidentNameEnglish" name="presidentNameEnglish"
                                placeholder="President's Name (write in English)"
                                value="{{old('presidentNameEnglish', $check_president_id->name_en ?? '')}}" required>
                        </div>
                        <div class="col-md-6 mt-4">
                            <label for="presidentDOB" class="form-label">জন্ম তারিখ (Date of Birth) <span
                                    class="text-danger">*</span></label>
                            <input type="date" data-provide="datepicker" data-date-format="dd/mm/yyyy" class="form-control"
                                id="presidentDOB" name="presidentDOB"
                                value="{{old('presidentDOB', $check_president_id->dob ?? '')}}" required>
                        </div>
                        <div class="col-md-6 mt-4">
                            <label for="presidentNID" class="form-label">জাতীয় পরিচয়পত্র নং (NID No.)<span
                                    class="text-danger">*</span></label>
                            <input type="text" pattern="^[0-9]{7,16}$" minlength="7" maxlength="16" class="form-control"
                                name="presidentNID" id="presidentNID" placeholder="NID No.(write in English)"
                                value="{{old('presidentNID', $check_president_id->nid ?? '')}}" required>
                        </div>
                        <div class="col-md-6 mt-4">
                            <label for="presidentPhone" class="form-label">ফোন (Phone)<span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="presidentPhone" name="presidentPhone"
                                placeholder="ফোন / Phone" pattern="[0-9]{11}" maxlength="11"
                                value="{{old('presidentPhone', $check_president_id->phone ?? '')}}" required>
                            @error('presidentPhone')
                                <div class="text-danger">Phone number cannot be same</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mt-4">
                            <label for="presidentEmail" class="form-label">ইমেইল (Email) <span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="presidentEmail" name="presidentEmail"
                                placeholder="ইমেইল / Email"
                                value="{{old('presidentEmail', $check_president_id->email ?? '')}}" required>
                        </div>
                        <div class="col-md-12 mt-4">
                            <label for="presidentImage" class="form-label">
                                <span>সভাপতির ছবি (President's Image) <span class="text-danger">*</span></span>
                            </label>
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-primary text-white">{{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose President\'s Image (IMAGE)') }}
                                </div>
                                <input type="hidden" id="presidentImage" name="presidentImage"
                                    value="{{ old('presidentImage', $check_president_id->image ?? '') }}"
                                    class="selected-files">
                            </div>
                            <div class="file-preview box sm"></div>
                        </div>

                    </div>
                </div>

                <div class="col-md-6 pr-4 pb-4">
                    <div class="row">
                        <div class="col-md-6 mt-4">
                            <label for="secretaryNameBangla" class="form-label">সাধাঃ সম্পাদকের নাম<span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="secretaryNameBangla" name="secretaryNameBangla"
                                placeholder="সাধাঃ সম্পাদকের নাম (বাংলায় লিখুন)"
                                value="{{old('secretaryNameBangla', $check_secretary_id->name_bn ?? '')}}" required>
                        </div>
                        <div class="col-md-6 mt-4">
                            <label for="secretaryNameEnglish" class="form-label">General Secretary's Name<span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="secretaryNameEnglish" name="secretaryNameEnglish"
                                placeholder="secretary's Name (write in English)"
                                value="{{old('secretaryNameEnglish', $check_secretary_id->name_en ?? '')}}" required>
                        </div>

                        <div class="col-md-6 mt-4">
                            <label for="secretaryDOB" class="form-label">জন্ম তারিখ (Date of Birth)<span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control" data-provide="datepicker" data-date-format="dd/mm/yyyy"
                                name="secretaryDOB" id="secretaryDOB"
                                value="{{old('secretaryDOB', $check_secretary_id->dob ?? '')}}" required>
                        </div>
                        <div class="col-md-6 mt-4">
                            <label for="secretaryNID" class="form-label">জাতীয় পরিচয়পত্র নং (NID No.)<span
                                    class="text-danger">*</span></label>
                            <input type="text" pattern="^[0-9]{7,16}$" minlength="7" maxlength="16" class="form-control"
                                name="secretaryNID" id="secretaryNID" placeholder="NID No.(write in English)"
                                value="{{old('secretaryNID', $check_secretary_id->nid ?? '')}}" required>
                        </div>


                        <div class="col-md-6 mt-4">
                            <label for="secretaryPhone" class="form-label">ফোন (Phone)<span
                                    class="text-danger">*</span></label>
                            <input type="text" pattern="[0-9]{11}" maxlength="11" class="form-control" name="secretaryPhone"
                                id="secretaryPhone" placeholder="ফোন / Phone"
                                value="{{old('secretaryPhone', $check_secretary_id->phone ?? '')}}" required>
                            @error('secretaryPhone')
                                <div class="text-danger">Phone number cannot be same</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mt-4">
                            <label for="secretaryEmail" class="form-label">ইমেইল (Email)<span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="secretaryEmail" id="secretaryEmail"
                                placeholder="ইমেইল / Email"
                                value="{{old('secretaryEmail', $check_secretary_id->email ?? '')}}" required>

                        </div>
                        <div class="col-md-12 mt-4">
                            <label for="secretaryImage" class="form-label">
                                <span>সাধাঃ সম্পাদকের ছবি (Secretary's Image)<span class="text-danger">*</span></span>
                            </label>
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-primary text-white">{{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose Secretary\'s Image (IMAGE)') }}
                                </div>
                                <input type="hidden" id="secretaryImage" name="secretaryImage"
                                    value="{{ old('secretaryImage', $check_secretary_id->image ?? '') }}"
                                    class="selected-files">
                            </div>
                            <div class="file-preview box sm"></div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="p-4">
                <h6 class="mt-4">ইংরেজিতে দক্ষ ব্যক্তির তথ্য (যদি থাকে)</h6>

                <div class="form-check ">
                    <input class="form-check-input" type="checkbox" id="englishProficientAvailable" style="transform: scale(1.5);">
                    <label class="form-check-label" for="englishProficientAvailable" style="font-size: 1.1rem; margin-top: -2px;">
                        Available
                    </label>
                </div>

                <div id="englishProficientForm" style="display: none;">
                    <div class="row">
                        <div class="col-md-4 mt-4">
                            <label for="englishProficientName" class="form-label">English-Proficient Person's Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="englishProficientName" name="englishProficientName"
                                placeholder="Enter Name (in English)"
                                value="{{ old('englishProficientName', $check_english_proficient_id->name_en ?? '') }}">
                        </div>
                        <div class="col-md-4 mt-4">
                            <label for="englishProficientDesignation" class="form-label">পদবী (Designation)<span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="englishProficientDesignation"
                                id="englishProficientDesignation" placeholder="পদবী / Designation"
                                value="{{old('englishProficientDesignation', $check_english_proficient_id->designation ?? '')}}">

                        </div>
                        <div class="col-md-4 mt-4">
                            <label for="englishProficientDOB" class="form-label">Date of Birth <span
                                    class="text-danger">*</span></label>
                            <input type="date" data-provide="datepicker" data-date-format="dd/mm/yyyy"
                                class="form-control datepicker" id="englishProficientDOB" name="englishProficientDOB"
                                value="{{ old('englishProficientDOB', $check_english_proficient_id->dob ?? '') }}">
                        </div>

                        <div class="col-md-4 mt-4">
                            <label for="englishProficientNID" class="form-label">National ID Number (NID) <span
                                    class="text-danger">*</span></label>
                            <input type="text" pattern="^[0-9]{7,16}$" minlength="7" maxlength="16" class="form-control"
                                id="englishProficientNID" name="englishProficientNID" placeholder="Enter NID Number"
                                value="{{ old('englishProficientNID', $check_english_proficient_id->nid ?? '') }}">
                        </div>
                        <div class="col-md-4 mt-4">
                            <label for="englishProficientEmail" class="form-label">ইমেইল (Email)<span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="englishProficientEmail"
                                id="englishProficientEmail" placeholder="ইমেইল / Email"
                                value="{{old('englishProficientEmail', $check_english_proficient_id->email ?? '')}}">
                        </div>
                        <div class="col-md-4 mt-4">
                            <label for="englishProficientPhone" class="form-label">Phone Number <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="englishProficientPhone"
                                name="englishProficientPhone" placeholder="Enter Phone Number" pattern="[0-9]{11}"
                                maxlength="11"
                                value="{{ old('englishProficientPhone', $check_english_proficient_id->phone ?? '') }}">
                            @error('englishProficientPhone')
                                <div class="text-danger">Phone number cannot be the same</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="row px-4 justify-content-between">
                <div class="mt-4">
                    <a type="submit" class="btn btn-danger" href="{{ route('organization.address.create') }}"> Previous
                    </a>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Save & Go Next</button>
                </div>
            </div>
        </form>
    </div>


@endsection

@section('script')
    <script>
        const today = new Date();

        const maxAge = new Date();
        maxAge.setFullYear(today.getFullYear() - 18);
        const maxAgeDate = maxAge.toISOString().split('T')[0];

        const minAge = new Date();
        minAge.setFullYear(today.getFullYear() - 36);
        const minAgeDate = minAge.toISOString().split('T')[0];

        document.getElementById('presidentDOB').setAttribute('max', maxAgeDate);
        document.getElementById('presidentDOB').setAttribute('min', minAgeDate);

        document.getElementById('secretaryDOB').setAttribute('max', maxAgeDate);
        document.getElementById('secretaryDOB').setAttribute('min', minAgeDate);

        document.getElementById('englishProficientDOB').setAttribute('max', maxAgeDate);
        document.getElementById('englishProficientDOB').setAttribute('min', minAgeDate);
    </script>

    <script>
        document.getElementById('englishProficientAvailable').addEventListener('change', function () {
            var form = document.getElementById('englishProficientForm');
            var inputs = form.querySelectorAll('input');

            if (this.checked) {
                form.style.display = 'block';
                inputs.forEach(input => {
                    input.setAttribute('required', 'required');
                });
            } else {
                form.style.display = 'none';
                inputs.forEach(input => {
                    input.removeAttribute('required');
                });
            }
        });
    </script>
@endsection