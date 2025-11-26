@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="align-items-center">
        <h1 class="h3">{{translate('All Shifts')}}</h1>
    </div>
    @can('add_shift')
        <div class="col text-right">
            <a href="{{ route('shifts.create') }}" class="btn btn-circle btn-info">
                <span>{{translate('Add New Shift')}}</span>
            </a>
        </div>
    @endcan
</div>

<div class="card">
    <form class="" id="sort_classes" action="" method="GET">
        <div class="card-header gutters-5">
            <div class="col">
                <h5 class="mb-0 h6">{{translate('Shifts')}}</h5>
            </div>

            <div class="col-md-3">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{translate('Shift')}}</th>
                        <th>{{translate('School')}}</th>
                        <th class="text-right">{{translate('Actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shifts as $key => $shift)
                    <tr>
                        <td>{{ ($key+1) + ($shifts->currentPage() - 1)*$shifts->perPage() }}</td>
                        <td>{{ $shift->name }}</td>
                        <td>{{ $shift->school->name }}</td>
                        <td class="text-right">
                            @can('edit_shift')
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('shifts.edit',$shift->id) }}" title="{{ translate('Edit') }}">
                                    <i class="las la-pen"></i>
                                </a>
                            @endcan
                            @can('delete_shift')
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{ route('shifts.destroy', $shift->id) }}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $shifts->appends(request()->input())->links() }}
            </div>
        </div>
    </form>
</div>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">
        function sort_shifts(el){
            $('#sort_shifts').submit();
        }
    </script>
@endsection
