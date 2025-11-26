@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
    <h1 class="h3">{{ translate('Coordinators List') }} for <span class="text-info">{{ $coordinators->first()?->school?->name }}</span></h1>
</div>

        @can('add_coordinator')
            <div class="col-md-6 text-md-right">
                <a href="javascript:void(0);" onclick="showAddEditCoordinatorForm('', '{{ $school_id }}')" class="add-coordinator btn btn-sm btn-circle btn-soft-info">
                    <i class="las la-plus"></i><span>{{translate('Add Coordinator')}}</span>
                </a>
            </div>
        @endcan
    </div>
</div>

<div class="card" id="add-edit-form" style="display: none;">
    <div class="card-header"></div>
    <div class="card-body"></div>
    <div class="card-footer"></div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{ translate('Coordinators') }}</h5>
    </div>
    <div class="card-body table-container">
        <div class="table-responsive">
            <table class="table mb-0" id="table-coordinators">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th>{{ translate('Name') }}</th>
                        <th>{{ translate('Email') }}</th>
                        <th>{{ translate('Phone') }}</th>
                        <th>{{ translate('Campus') }}</th>
                        <th>{{ translate('Shift') }}</th>
                        <th>{{ translate('Class') }}</th>
                        <th>{{ translate('Section') }}</th>
                        <th>{{ translate('Role') }}</th>
                        <th width="135px" class="text-right">{{ translate('Options') }}</th>
                    </tr>
                </thead>
            </table>
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
    $(document).ready(function () {
        var school_id = {{ $school_id }}; 
        
        var table = $('#table-coordinators').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("coordinators.index", ":school_id") }}'.replace(':school_id', school_id),
                type: 'GET',
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                    alert("Error fetching data. Please try again.");
                }
            },
            columns: [
                { data: null, render: function (data, type, row, meta) { return meta.row + 1 + meta.settings._iDisplayStart; }, orderable: false, width: "5%" },
                { data: 'user.name', render: function (data) { return data ? `<span class=" py-2 px-3 ">${data}</span>` : 'N/A'; } },
                { data: 'user.email', render: function (data) { return data ? `<span class=" py-2 px-3 ">${data}</span>` : 'N/A'; } },
                { data: 'user.phone', render: function (data) { return data ? `<span class=" py-2 px-3 ">${data}</span>` : 'N/A'; } },
                { data: 'campus.name', render: function (data) { return data ? `<span class=" py-2 px-3 ">${data}</span>` : 'N/A'; } },
                { data: 'shift.name', render: function (data) { return data ? `<span class=" py-2 px-3 ">${data}</span>` : 'N/A'; } },
                { data: 'class.name', render: function (data) { return data ? `<span class=" py-2 px-3 ">${data}</span>` : 'N/A'; } },
                { data: 'section.name', render: function (data) { return data ? `<span class=" py-2 px-3 ">${data}</span>` : 'N/A'; } },
                { data: 'role', render: function (data) { return data ? `<span class=" py-2 px-3 ">${data}</span>` : 'N/A'; } },
                { data: 'actions', orderable: false, searchable: false }
            ],
            language: {
                emptyTable: "No coordinators available",
                processing: "Loading..."
            }
        });
    });
     // Delete confirmation modal trigger
     $(document).on('click', '.confirm-delete', function(e) {
            e.preventDefault(); 
            var href = $(this).data('href');
            $('#delete-link').attr('href', href);

            $('#delete-modal').modal('show');
        });
</script>
<script>    
    function showAddEditCoordinatorForm(coordinator_id = '', school_id = '') {
    const addButton = $('.add-coordinator'); 
    const addEditForm = $('#add-edit-form'); 
    const isAdding = !coordinator_id;

    if (isAdding && addEditForm.is(':visible')) {
        addEditForm.hide();
        addButton.removeClass('btn-soft-danger').addClass('btn-soft-info');
        addButton.html('<i class="las la-plus"></i><span>{{ translate("Add Coordinator") }}</span>');
        return;
    }

    const url = isAdding
    ? "{{ route('coordinators.create', ':school_id') }}".replace(':school_id', school_id)
    : "{{ route('coordinators.edit', [':id', ':school_id']) }}"
        .replace(':id', coordinator_id)
        .replace(':school_id', school_id);

    $.ajax({
        type: 'GET',
        url: url,
        success: function (data) {
            const name = isAdding ? '{{ translate("Add Coordinator") }}' : '{{ translate("Edit Coordinator") }}';

            $('#add-edit-form .card-header').html(name);
            $('#add-edit-form .card-body').html(data);
            addEditForm.show();

            addButton.removeClass('btn-soft-info').addClass('btn-soft-danger');
            addButton.html('<i class="las la-times"></i><span>{{ translate("Close") }}</span>');
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
            alert("Failed to load the form. Please try again.");
        }
    });
}    
</script>

@endsection
