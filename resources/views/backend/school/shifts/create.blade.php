@extends('backend.layouts.app')

@section('content')

<div class="col-lg-6 mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Shift Information')}}</h5>
        </div>
        <form action="{{ route('shifts.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-from-label" for="school">{{ translate('School') }} <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="school_id" id="school_id" class="form-control aiz-selectpicker">
                            @foreach($schools as $school)
                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-from-label" for="name">{{ translate('Shift Name') }} <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" placeholder="{{ translate('Shift Name') }}" required>
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
