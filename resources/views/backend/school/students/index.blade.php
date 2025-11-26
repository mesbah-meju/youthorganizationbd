@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="align-items-center">
        <h1 class="h3">{{translate('All Students')}}</h1>
    </div>
    @can('add_student')
        <div class="col text-right">
            <a href="{{ route('students.create') }}" class="btn btn-circle btn-info">
                <span>{{translate('Add New Student')}}</span>
            </a>
        </div>
    @endcan
</div>

<div class="card">
    <form class="" id="sort_students" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-0 h6">{{translate('Students')}}</h5>
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
                        <th data-breakpoints="lg">#</th>
                        <th>{{translate('Name')}}</th>
                        <th data-breakpoints="lg">{{translate('School')}}</th>
                        <th data-breakpoints="lg">{{translate('Class')}}</th>
                        <th data-breakpoints="lg">{{translate('Section')}}</th>
                        <th data-breakpoints="lg">{{translate('Roll')}}</th>
                        <th data-breakpoints="lg">{{translate('Date Of Birth')}}</th>
                        <th data-breakpoints="lg">{{translate('Home Address')}}</th>
                        <th data-breakpoints="lg">{{translate('Family Income Range')}}</th>
                        <th class="text-right">{{translate('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $key => $student)
                        @if ($student != null)
                            <tr>
                                <td>{{ ($key+1) + ($students->currentPage() - 1)*$students->perPage() }}</td>
                                <td>{{ $student->name }}</td>
                                <td>
                                    @if($student->school)
                                    {{ $student->school->name }}
                                    @else
                                    —
                                    @endif
                                </td>
                                <td>
                                    @if($student->class)
                                    {{ $student->class->name }}
                                    @else
                                    —
                                    @endif
                                </td>
                                <td>
                                    @if($student->section)
                                    {{ $student->section->name }}
                                    @else
                                    —
                                    @endif
                                </td>
                                <td>{{ $student->roll }}</td>
                                <td>{{ $student->dob }}</td>
                                <td>{{ $student->home_address }}</td>
                                <td>{{ $student->family_income_range }}</td>
                                <td class="text-right">
                                    @can('edit_student')
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('students.edit', $student->id)}}" title="{{ translate('Edit') }}">
                                            <i class="las la-pen"></i>
                                        </a>
                                    @endcan
                                    @can('delete_student')
                                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('students.destroy', $student->id)}}" title="{{ translate('Delete') }}">
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
                {{ $students->appends(request()->input())->links() }}
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
        function sort_students(el){
            $('#sort_students').submit();
        }
    </script>
@endsection
