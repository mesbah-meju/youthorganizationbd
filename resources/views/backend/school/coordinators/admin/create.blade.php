@extends('backend.layouts.app')

@section('content')

<div class="col-lg-8 mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Add School Admin')}}</h5>
        </div>
        <form action="{{ route('classes.store') }}" method="POST">
            @csrf
            <div class="card-body">

                <div class="w-100">
                    <div class="form-row">
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
                    </div>
                </div>

                <!-- User Information -->
                <h5 class="mb-3 pb-3 pt-3 fs-15 fw-700" style="border-bottom: 1px dashed #e4e5eb;">{{translate('User Information')}}</h5>
                <div class="w-100">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="from-label" for="name">{{ translate('Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="{{ translate('Name') }}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label" for="phone">{{ translate('Phone') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="{{ translate('Phone') }}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label" for="name">{{translate('Role')}}</label>
                            <select name="role_id" class="form-control aiz-selectpicker" required>
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label" for="email">{{translate('Email Address')}} <span class="text-danger">*</span></label>
                            <input type="email" placeholder="{{ translate('Email Address') }}" class="form-control @error('email') is-invalid @enderror" name="email" id="email" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label" for="password">{{translate('Password')}} <span class="text-danger">*</span></label>
                            <input type="password" placeholder="{{ translate('Password') }}" class="form-control @error('password') is-invalid @enderror" name="password" id="password" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="from-label" for="password_confirmation">{{translate('Confirm Password')}} <span class="text-danger">*</span></label>
                            <input type="password" placeholder="{{ translate('Confirm Password') }}" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" required>
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
