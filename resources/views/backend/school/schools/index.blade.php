@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ translate('All Schools') }}</h1>
        </div>
        @can('add_school')
        <div class="col-md-6 text-md-right">
            <a href="javascript:void(0);" onclick="showAddEditSchoolForm()" class="btn btn-sm btn-circle btn-soft-info">
                <i class="las la-plus"></i> <span>{{ translate('Add New School') }}</span>
            </a>
        </div>
        @endcan
    </div>
</div>

<div class="card">
    <form id="sort_schools" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col d-flex justify-content-between align-items-center">
            @if(Route::currentRouteName() == 'schools.trashed' || Route::currentRouteName() == 'schools.restore')
                <h5 class="mb-0 h6">{{ translate('Trashed Schools') }}</h5>
            @else
                <h5 class="mb-0 h6">{{ translate('Active Schools') }}</h5>
            @endif
                <div class="btn-group">
                    @if(Route::currentRouteName() == 'schools.trashed' || Route::currentRouteName() == 'schools.restore')
                        <a href="{{ route('schools.index') }}" class="btn btn-sm btn-primary">{{ translate('Active Schools') }}</a>
                    @else
                        <a href="{{ route('schools.trashed') }}" class="btn btn-sm btn-danger">{{ translate('Trash') }}</a>
                    @endif
                </div>
            </div>
        </div>

        
        <div class="card-body p-0" style="max-height: 800px; overflow-y: auto;">
            <div style="overflow-x: auto;">
                <table class="table aiz-table mb-0" id="school-table">
                    <thead class="thead-light">
                        <tr>
                            <th data-breakpoints="lg">#</th>
                            <th>{{ translate('Organization') }}</th>
                            <th>{{ translate('Phone') }}</th>
                            <th>{{ translate('Email') }}</th>
                            <th>{{ translate('Status') }}</th>
                            <th>{{ translate('Social Link') }}</th>
                            <th class="text-right">{{ translate('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($schools->isNotEmpty())
                        @foreach($schools as $key => $school)
                        <tr>
                            <td class="text-center">{{ ($key+1) + ($schools->currentPage() - 1)*$schools->perPage() }}</td>
                            <td class="text-center">{{ $school->name }}</td>
                            <td class="text-center">{{ $school->code }}</td>
                            
                            <td class="text-center text-right">
                                @if($school->trashed())
                                <a href="javascript:void(0);" class="btn btn-soft-warning btn-icon btn-circle btn-sm" title="{{ translate('Restore') }}" onclick="confirmRestore('{{ route('schools.restore', $school->id) }}')">
                                    <i class="las la-undo"></i>
                                </a>

                                @else
                                    @can('login_as_school')
                                    <a href="{{ route('coordinators.index', $school->id) }}" class="btn btn-soft-success btn-icon btn-circle btn-sm" title="{{ translate('Manage Coordinator') }}">
                                        <i class="las la-user-plus"></i>
                                    </a>
                                    {{-- <a href="{{ route('schools.coordinators', $school->id) }}" class="btn btn-soft-success btn-icon btn-circle btn-sm" title="{{ translate('Manage Coordinator') }}">
                                        <i class="las la-user-plus"></i>
                                    </a> --}}
                                    @endcan
                                    @can('login_as_school')
                                    <a href="{{ route('schools.campuses', $school->id) }}" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="{{ translate('Manage Campus') }}">
                                        <i class="las la-graduation-cap"></i>
                                    </a>
                                    @endcan
                                    <a href="{{ route('schedules.index', $school->id) }}" class="btn btn-soft-info btn-icon btn-circle btn-sm" title="{{ translate('Schedules') }}">
                                        <i class="las la-calendar"></i>
                                    </a>
                                    @can('edit_school')
                                    <a href="javascript:void(0);" class="btn btn-soft-warning btn-icon btn-circle btn-sm" onclick="showAddEditSchoolForm('{{ $school->id }}')" title="{{ translate('Edit') }}">
                                        <i class="las la-pen"></i>
                                    </a>
                                    @endcan
                                    @can('delete_school')
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{ route('schools.destroy', $school->id) }}" title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                    @endcan
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td class="text-center" colspan="100%">
                                {{ translate('No data available') }}
                            </td>
                        </tr>  
                        @endif
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $schools->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </form>
</div>

<div id="restoreModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="restoreModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restoreModalLabel">{{ translate('Restore School') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ translate('Close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ translate('Are you sure you want to restore this school?') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ translate('Cancel') }}</button>
                <button type="button" class="btn btn-primary" id="restoreConfirmButton">{{ translate('Yes, Restore') }}</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('modal')
@include('modals.delete_modal')
@include('modals.add_edit_modal')
@endsection

@section('script')
<script type="text/javascript">

    function confirmRestore(restoreUrl) {
        $('#restoreConfirmButton').off('click').on('click', function() {
            window.location.href = restoreUrl; // Trigger the restore route
        });

        $('#restoreModal').modal('show');
    }
    function showAddEditSchoolForm(school_id = '') {
        $('#add-edit-modal .modal-title').html('');
        $('#add-edit-modal .modal-body').html('');

        if (school_id == '') {
            var name = 'Add New School';
            $.ajax({
                type: "GET",
                url: "{{ route('schools.create') }}",
                data: {},
                success: function(data) {
                    $('#add-edit-modal .modal-title').html(name);
                    $('#add-edit-modal .modal-body').html(data);
                    $('#add-edit-modal').modal('show');
                }
            });
        } else {
            var name = 'Edit School';
            $.ajax({
                type: "GET",
                url: "{{ route('schools.edit', ':id') }}".replace(':id', school_id),
                data: {},
                success: function(data) {
                    $('#add-edit-modal .modal-title').html(name);
                    $('#add-edit-modal .modal-body').html(data);
                    $('#add-edit-modal').modal('show');
                }
            });
        }
    }

    function sort_schools(el) {
        $('#sort_schools').submit();
    }
</script>
<script>
    $(document).ready(function() {
        $('#school-table').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthChange": true, 
            "pageLength": 25,     
            "lengthMenu": [10, 25, 50, 100], 
            "language": {
                "search": "{{ translate('Search') }}:",
                "paginate": {
                    "next": "{{ translate('Next') }}",
                    "previous": "{{ translate('Previous') }}"
                },
                "info": "{{ translate('Showing _START_ to _END_ of _TOTAL_ entries') }}",
                "lengthMenu": "{{ translate('Show _MENU_ entries') }}"
            }
        });
    });
</script>
@endsection