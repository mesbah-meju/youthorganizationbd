@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="align-items-center">
        <h1 class="h3">{{translate('All Classes')}}</h1>
    </div>
    @can('add_class')
        <div class="col text-right">
            <a href="{{ route('classes.create') }}" class="btn btn-circle btn-info">
                <span>{{translate('Add New Class')}}</span>
            </a>
        </div>
    @endcan
</div>

<div class="card">
    <form class="" id="sort_classes" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-0 h6">{{translate('Classes')}}</h5>
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
                        <th>{{translate('Name')}}</th>
                        <th>{{translate('Section')}}</th>
                        <th>{{translate('School')}}</th>
                        <th class="text-right">{{translate('Actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classes as $key => $class)
                        @if ($class != null)
                            <tr>
                                <td>{{ ($key+1) + ($classes->currentPage() - 1)*$classes->perPage() }}</td>
                                <td>{{ $class->name }}</td>
                                <td>
                                @if($class->sections->isNotEmpty())
                                    {{ $class->sections->pluck('name')->implode(', ') }}
                                @endif
                                </td>
                                <td>{{ $class->school->name }}</td>
                                <td class="text-right">
                                    @can('edit_class')
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('classes.edit', $class->id) }}" title="{{ translate('Edit') }}">
                                            <i class="las la-pen"></i>
                                        </a>
                                    @endcan
                                    @can('delete_class')
                                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('classes.destroy', $class->id)}}" title="{{ translate('Delete') }}">
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
                {{ $classes->appends(request()->input())->links() }}
            </div>
        </div>
    </form>
</div>
@endsection

@section('modal')
    <!-- Delete modal -->
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">
        function sort_classes(el){
            $('#sort_classes').submit();
        }
    </script>
@endsection
