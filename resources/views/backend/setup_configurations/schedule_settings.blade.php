@extends('backend.layouts.app')

@section('content')
   
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Schedule Setting')}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('schedule_settings.update') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label class="col-from-label">{{translate('Auto Schedule Settings')}}</label>
                            </div>
                            <div class="col-md-7">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input value="1" name="schedule_settings" type="checkbox" @if (get_setting('schedule_settings') == 1)
                                        checked
                                    @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="schedule_duration">
                            <div class="col-lg-3">
                                <label class="col-from-label">{{translate('Schedule Duration')}}</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="schedule_duration" value="{{ old('schedule_duration', $schedule_duration ?? 0) }}"  placeholder="{{ translate('Schedule Duration') }}" required>
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <input type="hidden" name="types[]" value="schedule_duration">
                            <div class="col-lg-3">
                                <label class="col-from-label">{{translate('Schedule Duration')}}</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="schedule_duration" value="{{  env('Schedule_Duration') }}" placeholder="{{ translate('Schedule Duration') }}" required>
                            </div>
                        </div> --}}
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
