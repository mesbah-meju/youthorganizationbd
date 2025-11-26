@extends('organization.layouts.app')

@section('panel_content')
    <div class="text-center mx-lg-5 mx-md-auto">
        <h4 class="bg-success text-white rounded py-3 px-2 mx-lg-5 mx-md-auto shadow-lg">
            Welcome to Youth Organization Database, Bangladesh
        </h4>
    </div>

    <!-- form container -->
    <div class="row d-flex justify-content-space-betweeen">

        <div class="container bg-white border shadow rounded px-4 pt-4 pb-3 mt-4 mb-5 fw-600">
            <h5 class="text-center text-decoration-underlined">নিম্নোক্ত ফাইলগুলো সংযুক্তি আকারে আপলোড করুন।</h5>

            <form class="pt-4" action="{{ route('organization.document.store') }}" method="POST">
                @csrf

                <div class="row d-flex">
                    @if ($org_details->reg_type == 'registered')
                        <div class="form-group col-md-6 my-4">
                            <label for="reg_doc">
                                সংগঠন নিবন্ধনের নথিপত্র (Organization registration documents)<span class="text-danger">*</span>
                            </label>
                            <div class="input-group" data-toggle="aizuploader" data-type="document">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-primary text-white">সংযুক্তি</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('nothing selected') }}</div>
                                <input type="hidden" name="reg_doc" value="{{old('reg_doc', $documents->reg_doc ?? '')}}"
                                    class="selected-files">
                            </div>
                            @error('reg_doc')
                                <div class="text-danger">Please add Organization registration documents</div>
                            @enderror
                            <div class="file-preview box sm text-right">
                            </div>
                        </div>
                    @endif

                    <div class="form-group col-md-6 my-4">
                        <label for="constitution">
                            সংগঠনের গঠনতন্ত্রের অনুলিপি (Copy of Organization's constitution)<span
                                class="text-danger">*</span>
                        </label>
                        <div class="input-group" data-toggle="aizuploader" data-type="document">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-primary text-white">সংযুক্তি</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('nothing selected') }}</div>
                            <input type="hidden" name="constitution"
                                value="{{old('constitution', $documents->constitution ?? '')}}" class="selected-files">
                        </div>
                        @error('constitution')
                            <div class="text-danger">Please add constitution</div>
                        @enderror
                        <div class="file-preview box sm text-right">
                        </div>
                    </div>

                    <div class="form-group col-md-6 my-4">
                        <label for="general_members">
                            সাধারণ সদস্যদের নামের তালিকা (List of names of general members)<span
                                class="text-danger">*</span>
                        </label>
                        <div class="input-group" data-toggle="aizuploader" data-type="document">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-primary text-white">সংযুক্তি</div>
                            </div>
                            <div class="form-control file-amount">nothing selected</div>
                            <input type="hidden" name="general_members"
                                value="{{old('general_members', $documents->general_members ?? '')}}"
                                class="selected-files">
                        </div>
                        @error('general_members')
                            <div class="text-danger">Please add general members list</div>
                        @enderror
                        <div class="file-preview box sm">
                        </div>
                    </div>

                    <div class="form-group col-md-6 my-4">
                        <label for="council_members">
                            কার্যনির্বাহী পরিষদের সদস্যদের তালিকা (List of Executive Council members)<span
                                class="text-danger">*</span>
                        </label>
                        <div class="input-group" data-toggle="aizuploader" data-type="document">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-primary text-white">সংযুক্তি</div>
                            </div>
                            <div class="form-control file-amount">nothing selected</div>
                            <input type="hidden" name="council_members"
                                value="{{old('council_members', $documents->council_members ?? '')}}"
                                class="selected-files">
                        </div>
                        @error('council_members')
                            <div class="text-danger">Please add council members list</div>
                        @enderror
                        <div class="file-preview box sm"></div>
                    </div>
                    <div class="col-md-6 mt-5">
                        <ul>
                            <li>
                                <a href="{{ asset('sample.pdf') }}" download="sample.pdf"><u>Click here for sample.</u></a>
                            </li>
                            <li>Upload Files as PDF, size less than 1 MB.</li>
                            <li>If already uploaded, no need to select again.</li>
                        </ul>
                    </div>

                </div>
                <div class="row justify-content-between">
                    <div class="my-4">
                        <a class="btn btn-danger" href="{{ route('organization.challan.create') }}"> Previous
                        </a>
                    </div>
                    <div class="my-4">
                        <button type="submit" class="btn btn-primary">Save & Go Next</button>
                    </div>
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
        document.getElementById('establishment_date').setAttribute('max', formattedDate);
    </script>
@endsection