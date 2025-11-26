@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
    <h1 class="h3">{{ translate('All Coordinators') }} <span class="text-info">{{ $coordinators->first()?->school?->name }}</span></h1>
</div>

        @can('add_coordinator')
            <div class="col-md-6 text-md-right">
                <a href="javascript:void(0);" onclick="showAddEditCoordinatorForm('', '{{ $school_id }}')" class="btn btn-sm btn-circle btn-soft-info">
                    <i class="las la-plus"></i><span>{{translate('Add Coordinator')}}</span>
                </a>
            </div>
        @endcan
	</div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Coordinators')}}</h5>
    </div>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th width="10%">#</th>
                    <th>{{translate('Name')}}</th>
                    <th>{{translate('Email')}}</th>
                    <th>{{translate('Phone')}}</th>
                    <th>{{translate('Role')}}</th>
                    <th width="135px" class="text-right">{{translate('Actions')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($coordinators as $key => $coordinator)
                    @if($coordinator != null)
                        <tr>
                            <td>{{ ($key+1) + ($coordinators->currentPage() - 1)*$coordinators->perPage() }}</td>
                            <td>{{$coordinator->user->name ?? ''}}</td>
                            <td>{{$coordinator->user->email ?? ''}}</td>
                            <td>{{$coordinator->user->phone ?? ''}}</td>
                            <td>
								{{-- @if ($coordinator->user->userrole != null)
									{{ $coordinator->user->userrole->role->getTranslation('name') }}
								@endif --}}
							</td>
                            <td class="text-right">
                                @can('login_as_coordinator')
                                    <a href="{{ route('coordinators.login', encrypt($coordinator->id)) }}" class="btn btn-soft-success btn-icon btn-circle btn-sm" title="{{ translate('Login as Coordinator') }}">
                                        <i class="las la-sign-in-alt"></i>
                                    </a>
                                @endif
                                @can('edit_coordinator')
                                <a href="javascript:void(0);" class="btn btn-soft-warning btn-icon btn-circle btn-sm" onclick="showAddEditCoordinatorForm('{{ $coordinator->id }}', '{{ $coordinator->school_id }}')" title="{{ translate('Edit') }}">
                                    <i class="las la-pen"></i>
                                </a>
                                
                                @endcan
                                @can('delete_coordinator')
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('coordinators.destroy', $coordinator->id)}}" title="{{ translate('Delete') }}">
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
            {{ $coordinators->appends(request()->input())->links() }}
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
        function showAddEditCoordinatorForm(coordinator_id = '', school_id = '') {
            $('#add-edit-modal .modal-title').html('');
            $('#add-edit-modal .modal-body').html('');

            if(coordinator_id == '') {
                var name = 'Add Coordinator';
                $.ajax({
                    type: "GET",
                    url: "{{ route('coordinators.create', ':school_id') }}".replace(':school_id', school_id),
                    data: {},
                    success: function(data) {
                        $('#add-edit-modal .modal-title').html(name);
                        $('#add-edit-modal .modal-body').html(data);
                        $('#add-edit-modal').modal('show');
                    }
                });
            } else {
                var name = 'Edit Coordinator';
                $.ajax({
                    type: "GET",
                    url: "{{ route('coordinators.edit', [':id', ':school_id']) }}".replace(':id', coordinator_id).replace(':school_id', school_id),
                    data: {},
                    success: function(data) {
                        $('#add-edit-modal .modal-title').html(name);
                        $('#add-edit-modal .modal-body').html(data);
                        $('#add-edit-modal').modal('show');
                    }
                });
            }
        }
    
        function sort_coordinators(el){
            $('#sort_coordinators').submit();
        }
    </script>
@endsection

