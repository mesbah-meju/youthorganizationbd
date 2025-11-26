@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('All Active Users') }}</h1>
            </div>
            {{-- @can('add_director')
                <div class="col-md-6 text-md-right">
                    <a href="{{ route('directors.create') }}" class="btn btn-circle btn-info">
                        <span>{{ translate('Add User') }}</span>
                    </a>
                </div>
            @endcan --}}
        </div>
    </div>

    <div class="card">
        <form class="" id="sort_directors" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('Active Users') }}</h5>
                </div>

                <div class="col-md-2 ml-auto">
                    <select name="division_id" id="division_id" class="form-control aiz-selectpicker" data-live-search="true" onchange="sort_directors(this.id); divisionWiseDistrict(this.value)">
                        <option value="">Select Division</option>
                        @foreach($divisions as $division)
                        <option value="{{ $division->id }}" @isset($division_id) @if($division->id == $division_id ) selected @endif @endisset>
                            {{ $division->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 ml-auto">
                    <select name="district_id" id="district_id" class="form-control aiz-selectpicker" data-live-search="true" onchange="sort_directors(this.id); districtWiseUpazila(this.value)">
                        <option value="">Select District</option>
                        @foreach($districts as $district)
                        <option value="{{ $district->id }}" @isset($district_id) @if($district->id == $district_id ) selected @endif @endisset>
                            {{ $district->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 ml-auto">
                    <select name="upazila_id" id="upazila_id" class="form-control aiz-selectpicker" data-live-search="true" onchange="sort_directors(this.id)">
                        <option value="">Select Upazila</option>
                        @foreach($upazilas as $upazila)
                        <option value="{{ $upazila->id }}" @isset($upazila_id) @if($upazila->id == $upazila_id ) selected @endif @endisset>
                            {{ $upazila->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 ml-auto">
                    <select name="role_id" id="role_id" class="form-control aiz-selectpicker" data-live-search="true" onchange="sort_directors(this.id)">
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}" @isset($role_id) @if($role->id == $role_id ) selected @endif @endisset>
                            {{ $role->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control form-control-sm" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type & Enter') }}">
                    </div>
                </div>
            </div>
        </form>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th>{{ translate('Name') }}</th>
                        <th>{{ translate('Email') }}</th>
                        <th>{{ translate('Phone') }}</th>
                        <th>{{ translate('Division') }}</th>
                        <th>{{ translate('District') }}</th>
                        <th>{{ translate('Upazila') }}</th>
                        <th>{{ translate('Role') }}</th>
                        <th>{{ translate('Status') }}</th>
                        <th width="15%" class="text-right">{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                        <tr>
                            <td>{{ ($key + 1) + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->division_name ? $user->division_name : 'N/A' }}</td>
                            <td>{{ $user->district_name ? $user->district_name : 'N/A' }}</td>
                            <td>{{ $user->upazila_name ? $user->upazila_name : 'N/A' }}</td>
                            <td>{{ $user->role_name ?? '' }}</td>
                            <td>
                                @if($user->is_approved == 1)
                                    <span class="badge bg-success w-auto fw-600 text-light">Active</span>
                                @else
                                    <span class="badge bg-warning w-auto fw-600 text-light">Inactive</span>
                                @endif
                            </td>
                            <td class="text-right">
                                @can('edit_director')
                                    @if($user->is_approved == 1)
                                        <a href="javascript::void();" class="btn btn-soft-success btn-icon btn-circle btn-sm confirm-reject"
                                            data-href="{{ route('directors.approve', $user->id) }}" title="deactivate"><i
                                                class="las la-check"></i> </a>
                                    @else
                                        <a href="javascript::void();" class="btn btn-soft-warning btn-icon btn-circle btn-sm confirm-approve"
                                            data-href="{{ route('directors.approve', $user->id) }}" title="activate"><i
                                                class="las la-check"></i> </a>
                                    @endif
                                @endcan
                                @can('edit_director')
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                        href="{{ route('directors.edit', encrypt($user->id)) }}" title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                @endcan
                                @can('delete_director')
                                    <a href="javascript::void();" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="{{ route('directors.destroy', $user->id) }}" title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $users->appends(request()->input())->links() }}
            </div>
        </div>
    </div>

@endsection

@section('modal')
    @include('modals.delete_modal')
    @include('modals.approve_modal')
    @include('modals.reject_modal')
@endsection

@section('script')
<script type="text/javascript">
    function sort_directors() {
        $('#sort_directors').submit();
    }

    $('#search').keyup(function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            sort_directors();
        }
    });

    function divisionWiseDistrict(division_id) {
        $.ajax({
            type: "GET",
            url: "{{ route('division-wise-district', '') }}/" + division_id,
            success: function(response) {
                $('#district_id').html(response);
            }
        });
    }
    function districtWiseUpazila(district_id) {
        $.ajax({
            type: "GET",
            url: "{{ route('district-wise-upazila', '') }}/" + district_id,
            success: function(response) {
                $('#upazila_id').html(response);
            }
        });
    }
</script>
@endsection