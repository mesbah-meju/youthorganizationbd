@extends('organization.layouts.app')

@section('panel_content')
<div class="text-center mx-lg-5 mx-md-auto">
    <h4 class="bg-success text-white rounded py-3 px-2 mx-lg-5 mx-md-auto shadow-lg">
        Welcome to Youth Organization Database, Bangladesh
    </h4>
</div>

<div class="container bg-white border shadow rounded px-5 pt-4 my-5 fw-600">
    <h5 class="text-center text-decoration-underlined">সংগঠনের কর্মপরিকল্পনা (Organization's Activity)</h5>
    <form class="pt-4" action="{{route('organization.activity.store')}}" method="POST">
        @csrf

        <div class="row">

            <div class="col-md-6 my-3 d-flex gutter-none">
                <div class="col-md-9 px-0">
                    <label for="objectives" class="form-label">লক্ষ্য ও উদ্দেশ্য (Objectives)</label>
                    <textarea maxlength="1000" class="form-control" id="objectives" name="objectives" rows="6" placeholder="Objectives (write in English)">{{ old('objectives', $organization_activity->objectives ?? '') }}</textarea>
                    <p class="text-muted"> *Attach as pdf if more than 200 words</p>
                </div>
                <div class="col-md-3 mt-4">
                    <div class="input-group" data-toggle="aizuploader" data-type="document">
                        <div class="input-group-text bg-primary text-white"><i class="las la-plus mr-2"></i>সংযুক্তি</div>
                        <input type="hidden" name="objectives_doc" value="{{old('objectives_doc',$organization_activity->objectives_doc ?? '')}}" class="selected-files">
                    </div>
                    <div class="file-preview box sm">
                    </div>
                </div>
            </div>

            <div class="col-md-6 my-3 d-flex">
                <div class="col-md-9 px-0">
                    <label for="planning" class="form-label">কর্মপরিকল্পনা (Plannings)</label>
                    <textarea maxlength="1000" class="form-control" id="planning" name="planning" rows="6" placeholder="Plannings (write in English)">{{ old('planning', $organization_activity->plan ?? '') }}</textarea>
                    <p class="text-muted"> *Attach as pdf if more than 200 words</p>
                </div>
                <div class="col-md-3 mt-4">
                    <div class="input-group" data-toggle="aizuploader" data-type="document">
                        <div class="input-group-text bg-primary text-white"><i class="las la-plus mr-2"></i>সংযুক্তি</div>
                        <input type="hidden" name="planning_doc" value="{{old('planning_doc',$organization_activity->plan_doc ?? '')}}" class="selected-files">
                    </div>
                    <div class="file-preview box sm">
                    </div>
                </div>
            </div>
        </div>

        <h6 class="mt-4">বিগত সাধারন সভা যে তারিখে অনুষ্ঠিত হইয়াছে সেই তারিখের তথ্য</h6>
        <div class="row">
            <!-- Meeting Date -->
            <div class="col-md-4 mt-3">
                <label for="lastMeetingDate" class="form-label">তারিখ: </label>
                <input type="date" class="form-control" id="lastMeetingDate" name="lastMeetingDate" placeholder="শেষ সভার তারিখ" value="{{old('lastMeetingDate', $organization_activity->last_meeting_date ?? '')}}" >
            </div>

            <!-- Total Members -->
            <div class="col-md-4 mt-3">
                <label for="totalMembersLastMeeting" class="form-label">
                    মোট সদস্য সংখ্যা:
                </label>
                <input type="number" class="form-control" id="totalMembersLastMeeting" name="totalMembersLastMeeting" placeholder="মোট সদস্য সংখ্যা" value="{{old('totalMembersLastMeeting', $organization_activity->total_members_last_meeting ?? '')}}">
            </div>
            <div class="col-md-4 mt-3">
                <label for="totalMembersLastMeeting" class="form-label">
                    কার্যবিবরণীর অনুলিপি:
                </label>
                <div class="input-group" data-toggle="aizuploader" data-type="document">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-primary text-white">সংযুক্তি</div>
                    </div>
                    <div class="form-control file-amount">{{ translate('nothing selected') }}</div>
                    <input type="hidden" name="members_opinion_doc" value="{{old('members_opinion_doc',$organization_activity->members_opinion_doc ?? '')}}" class="selected-files">
                </div>
                <div class="file-preview box sm">
                </div>
            </div>
        </div>

        <div class="row mt-5 justify-content-between">
            <div class="my-3">
                <a type="submit" class="btn btn-danger" href="{{ route('organization.banks.create') }}"> Previous</a>
            </div>
            <div class="my-3">
                <button type="submit" class="btn btn-primary"> Save & Go Next
                </button>
            </div>
        </div>
    </form>
</div>

@endsection