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

        <form class="pt-4" action="{{ route('organization.challan.store') }}" method="POST">
            @csrf

            <div class="row d-flex">
                <div class="form-group col-md-6 my-4">
                    <label for="challan">
                        <span>(পাঁচশত) টাকার ট্রেজারি চালানের কপি (Copy of treasury challan) <span class="text-danger">*</span></span>
                    </label>
                    <div class="input-group" data-toggle="aizuploader" data-type="document">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-primary text-white">সংযুক্তি</div>
                        </div>
                        <div class="form-control file-amount">{{ translate('nothing selected') }}</div>
                        <input type="hidden" name="challan" value="{{old('challan',$documents->challan ?? '')}}" class="selected-files" required>

                    </div>
                    @error('challan')
                    <div class="text-danger">Please add challan</div>
                    @enderror
                    <div class="file-preview box sm text-right">
                    </div>
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
                    <a class="btn btn-danger" href="{{ route('organization.domains.create') }}"> Previous
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