@extends('backend.layouts.app')

@section('content')

    <div class="card">
        <form id="sort_schools" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 h6">{{ translate('Organizations') }}</h5>
                </div>
            </div>

            <div class="card-body">
                <div style="overflow-x: auto;">
                    <table class="table mb-0" id="organization-table" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th data-breakpoints="lg">#</th>
                                <th>{{ translate('Organization') }}</th>
                                <th>{{ translate('Email') }}</th>
                                <th>{{ translate('Phone') }}</th>
                                <th>{{ translate('Established Date') }}</th>
                                <th>{{ translate('Status') }}</th>
                                {{-- <th class="text-right">{{ translate('Actions') }}</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @if ($organizations->isNotEmpty())
                                @foreach ($organizations as $key => $organization)
                                    <tr>
                                        <td>{{ $key + 1 + ($organizations->currentPage() - 1) * $organizations->perPage() }}
                                        </td>
                                        <td>{{ $organization->org_name_en }}</td>
                                        <td>
                                            @if($organization->user)
                                            {{ $organization->user->email }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td>
                                            @if($organization->user)
                                            {{ $organization->user->phone }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td>
                                            {{ date('F d, Y', strtotime($organization->established_date)) }}
                                        </td>
                                        <td>
                                            @if($organization->status == 0)
                                            {{ translate('Draft') }}
                                            @elseif($organization->status == 1)
                                            {{ translate('Pending') }}
                                            @elseif($organization->status == 2)
                                            {{ translate('Approved') }}
                                            @elseif($organization->status == 3)
                                            {{ translate('Rejectd') }}
                                            @endif
                                        </td>
                                        {{-- <td class="text-right">
                                            @can('show_organization')
                                                <a href="{{ route('organizations.show', $organization->id) }}"class="btn btn-soft-success btn-icon btn-circle btn-sm" title="{{ translate('View') }}">
                                                    <i class="las la-eye"></i>
                                                </a>
                                            @endcan
                                        </td> --}}
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        {{ $organizations->appends(request()->input())->links() }}
                    </div>
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
    <script>
        $(document).ready(function() {
            $('#organization-table').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthChange: true,
                pageLength: 25,
                lengthMenu: [10, 25, 50, 100],
                language: {
                    emptyTable: "{{ translate('No data available in table') }}",
                    search: "{{ translate('Search') }}:",
                    paginate: {
                        next: "{{ translate('Next') }}",
                        previous: "{{ translate('Previous') }}"
                    },
                    info: "{{ translate('Showing _START_ to _END_ of _TOTAL_ entries') }}",
                    lengthMenu: "{{ translate('Show _MENU_ entries') }}"
                },
                autoWidth: false,
                responsive: true
            });
        });
    </script>
@endsection
