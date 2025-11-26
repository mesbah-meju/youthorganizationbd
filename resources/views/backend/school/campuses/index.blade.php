@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('Campuses List')}} for <span class="text-info"> {{ $schools[0]->name }} </span></h1>
        </div>
        @can('add_campus')
            <div class="col-md-6 text-md-right">
                <a href="javascript:void(0);" onclick="showAddEditCampusForm('', '{{ $school_id }}')" class="btn btn-sm btn-circle btn-soft-info">
                    <i class="las la-plus"></i><span>{{translate('Add New Campus')}}</span>
                </a>
            </div>
        @endcan
    </div>
</div>

<div class="card">
    <form class="" id="sort_campuses" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-0 h6">{{translate('Campuses')}}</h5>
            </div>

            <div class="col-md-3">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" id="sort_search" name="sort_search" @isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th data-breakpoints="lg">#</th>
                        <th>{{ translate('Campus Name') }}</th>
                        <th>{{ translate('School Name') }}</th>
                        <th>{{ translate('Code') }}</th>
                        <th>{{ translate('Address') }}</th>
                        <th>{{ translate('Coordinators') }}</th>
                        <th width="170px" class="text-right" >{{translate('Actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($campuses as $key => $campus)
                        @if ($campus != null)
                            <tr>
                                <td>{{ ($key+1) + ($campuses->currentPage() - 1)*$campuses->perPage() }}</td>
                                <td>{{ $campus->name }}</td>
                                <td>{{ $campus->school->name }}</td>
                                <td>{{ $campus->code }}</td>
                                <td>{{ $campus->address }}</td>
                                <td>
                                    @if($campus->coordinators()->count() > 0)
                                        {{ $campus->coordinators()->count() }}
                                    @else 
                                        {{ translate('N/A') }}
                                    @endif
                                </td>
                                <td class="text-right">
                                    {{-- @can('edit_coordinator')
                                    <a href="{{ route('campus_coordinator.index', ['school_id' => $school_id, 'campus_id' => $campus->id]) }}" class="btn btn-soft-success btn-icon btn-circle btn-sm" title="{{ translate('Manage Coordinator') }}">
                                        <i class="las la-user-plus"></i>
                                    </a>
                                    
                                    @endif --}}
                                    @can('edit_campus')
                                        <a href="javascript:void(0);" class="btn btn-soft-warning btn-icon btn-circle btn-sm" onclick="showAddEditCampusForm('{{ $campus->id }}', '{{$school_id}}')" title="{{ translate('Edit') }}">
                                            <i class="las la-pen"></i>
                                        </a>
                                    @endcan
                                    @can('delete_campus')
                                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('campuses.destroy', $campus->id)}}" title="{{ translate('Delete') }}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $campuses->appends(request()->input())->links() }}
            </div>
        </div>
    </form>
</div>
@endsection

@section('modal')
    @include('modals.delete_modal')
    @include('modals.add_edit_modal')
@endsection

@section('script')
<script type="text/javascript">
    function showAddEditCampusForm(campus_id = '', school_id = '') {
    $('#add-edit-modal .modal-title').html('');
    $('#add-edit-modal .modal-body').html('');

    if (campus_id === '') {
        var name = 'Add New Campus';
        var url = "{{ route('campuses.create', ':school_id') }}".replace(':school_id', school_id);

        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                $('#add-edit-modal .modal-title').html(name);
                $('#add-edit-modal .modal-body').html(data);
                $('#add-edit-modal').modal('show');
            },
            error: function() {
                alert('Failed to load the Add Campus form.');
            }
        });
    } else {
        var name = 'Edit Campus';
        var url = "{{ route('campuses.edit', [':id', ':school_id']) }}".replace(':id', campus_id).replace(':school_id', school_id);

        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                $('#add-edit-modal .modal-title').html(name);
                $('#add-edit-modal .modal-body').html(data);
                $('#add-edit-modal').modal('show');
            },
            error: function() {
                alert('Failed to load the Edit Campus form.');
            }
        });
    }
}


    function sort_campuses(el){
        $('#sort_campuses').submit();
    }
</script>

@endsection
