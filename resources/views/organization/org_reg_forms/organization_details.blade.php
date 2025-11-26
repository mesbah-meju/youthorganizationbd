@extends('organization.layouts.app')

@section('panel_content')
    <div class="text-center mx-lg-5 mx-md-auto">
        <h4 class="bg-success text-white rounded py-3 px-2 mx-lg-5 mx-md-auto shadow-lg">
            Welcome to Youth Organization Database, Bangladesh
        </h4>
    </div>

    <!-- Form Container -->
    <div class="row d-flex justify-content-space-between">
        <div class="container bg-white border shadow rounded px-4 pt-4 pb-3 mt-4 mb-5 fw-600">
            <h5 class="text-center text-decoration-underline">সংগঠনের তথ্য (Organization's Information)</h5>

            <form class="pt-4" action="{{ route('organization.details.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row d-flex">
                    <!-- Left Column: Logo and File Uploads -->
                    <div class="col-md-4">
                        <div class="form-group mt-4">
                            <label for="logo">
                                সংগঠনের লোগো (Organization Logo) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-primary text-white">{{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('nothing selected') }}</div>
                                <input type="hidden" name="logo" value="{{ old('logo', $org_details->logo ?? '') }}"
                                    class="selected-files" required>
                            </div>
                            <div class="file-preview box sm"></div>
                            <small class="text-muted">Upload Logo as image, size less than 1 MB. If already uploaded, no
                                need to select again.</small>
                        </div>


                        @if ($org_details->reg_type == 'registered')
                            <div>
                                <label for="old_reg_type" class="form-label">নিবন্ধনের ধরণ(Registration Type) <span
                                        class="text-danger">*</span></label>
                                <select name="old_reg_type" class="form-control" required>
                                    <option value="">নির্বাচন করুন (Select)</option>
                                    <option value="registered" {{ old('old_reg_type', $org_details->old_reg_type ?? '') == 'registered' ? 'selected' : '' }}>নিবন্ধিত (Registered)</option>
                                    <option value="affiliated" {{ old('old_reg_type', $org_details->old_reg_type ?? '') == 'affiliated' ? 'selected' : '' }}>আফিলিয়েটেড (Affiliated)</option>
                                    <option value="enlisted" {{ old('old_reg_type', $org_details->old_reg_type ?? '') == 'enlisted' ? 'selected' : '' }}>এনলিস্টেড (Enlisted)</option>
                                </select>
                            </div>

                            <div class="mt-4">
                                <label for="reg_no" class="form-label">নিবন্ধন নম্বর(Registration No.)<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="reg_no" name="reg_no"
                                    placeholder="Registration No.(write in English)"
                                    value="{{ old('reg_no', $org_details->reg_no ?? '') }}" required>
                                @error('reg_no')
                                    <div class="text-danger">This Field is Mandatory</div>
                                @enderror
                            </div>
                        @endif


                    </div>



                    <!-- Right Column: Organization Details -->
                    <div class="col-md-8 border-left">
                        <div class="row">
                            <!-- Organization Name (Bangla) -->
                            <div class="col-md-6 mt-4">
                                <label for="org_name_bn" class="form-label">সংগঠনের নাম <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="org_name_bn" name="org_name_bn"
                                    placeholder="সংগঠনের নাম (বাংলায় লিখুন)"
                                    value="{{ old('org_name_bn', $org_details->org_name_bn ?? '') }}" required>
                                @error('org_name_bn')
                                    <div class="text-danger">Please insert name in 'Bangla'</div>
                                @enderror
                            </div>

                            <!-- Organization Name (English) -->
                            <div class="col-md-6 mt-4">
                                <label for="org_name_en" class="form-label">Organization Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="org_name_en" name="org_name_en"
                                    placeholder="Organization Name (write in English)"
                                    value="{{ old('org_name_en', $org_details->org_name_en ?? '') }}" required>
                                @error('org_name_en')
                                    <div class="text-danger">Please insert name in 'English'</div>
                                @enderror
                            </div>

                            <!-- Organization Type -->
                            <div class="col-md-6 mt-4">
                                <label for="org_type" class="form-label">সংগঠনের ধরণ (Organization Type) <span
                                        class="text-danger">*</span></label>
                                <select name="org_type" class="form-control" required>
                                    <option value="">নির্বাচন করুন (Select)</option>
                                    <option value="General" {{ old('org_type', $org_details->org_type ?? '') == 'General' ? 'selected' : '' }}>সাধারণ (General)</option>
                                    <option value="Youth Women" {{ old('org_type', $org_details->org_type ?? '') == 'Youth Women' ? 'selected' : '' }}>যুবনারী (Youth Women)</option>
                                    <option value="Youth Disabled" {{ old('org_type', $org_details->org_type ?? '') == 'Youth Disabled' ? 'selected' : '' }}>যুবপ্রতিবন্ধী (Youth Disabled)</option>
                                    <option value="Special Needs" {{ old('org_type', $org_details->org_type ?? '') == 'Special Needs' ? 'selected' : '' }}>বিশেষ চাহিদা সম্পন্ন (Special Needs)</option>
                                    <option value="Third Gender" {{ old('org_type', $org_details->org_type ?? '') == 'Third Gender' ? 'selected' : '' }}>তৃতীয় লিঙ্গ (Third Gender)</option>
                                    <option value="Youth Women and Disabled" {{ old('org_type', $org_details->org_type ?? '') == 'Youth Women and Disabled' ? 'selected' : '' }}>যুবনারী ও প্রতিবন্ধী (Youth
                                        Women and Disabled)</option>
                                </select>
                            </div>

                            <!-- Establishment Date -->
                            <div class="col-md-6 mt-4">
                                <label for="established_date" class="form-label">প্রতিষ্ঠার তারিখ (Establishment Date) <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="established_date" id="established_date"
                                    placeholder="সংগঠন প্রতিষ্ঠার তারিখ (Establishment Date)"
                                    value="{{ old('established_date', $org_details->established_date ?? '') }}" required>
                                @error('established_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Work Area -->
                            <div class="col-md-6 mt-4">
                                <label for="work_area" class="form-label">কর্মক্ষেত্র (Work Areas)<span
                                        class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <div class="m-auto">
                                        <input type="radio" id="local" name="work_area" value="local" {{ old('work_area', $org_details->work_area ?? '') == 'local' ? 'checked' : '' }}>
                                        <label for="local">স্থানীয়</label>
                                    </div>
                                    <div class="m-auto">
                                        <input type="radio" id="upazila" name="work_area" value="upazila" {{ old('work_area', $org_details->work_area ?? '') == 'upazila' ? 'checked' : '' }}>
                                        <label for="upazila">উপজেলা</label>
                                    </div>
                                    <div class="m-auto">
                                        <input type="radio" id="district" name="work_area" value="district" {{ old('work_area', $org_details->work_area ?? '') == 'district' ? 'checked' : '' }}>
                                        <label for="district">জেলা</label>
                                    </div>
                                    <div class="m-auto">
                                        <input type="radio" id="other" name="work_area" value="other" {{ old('work_area', $org_details->work_area ?? '') == 'other' ? 'checked' : '' }}>
                                        <label for="other">অন্যান্য</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-right mt-2">
                    <button type="submit" class="btn btn-primary">Save & Go Next</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const today = new Date();
        today.setDate(today.getDate() - 15);
        const formattedDate = today.toISOString().split('T')[0];
        document.getElementById('established_date').setAttribute('max', formattedDate);
    </script>
@endsection