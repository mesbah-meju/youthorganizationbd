@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">{{ translate('All Users') }}</h1>
		</div>
        @can('add_user')
            <div class="col-md-6 text-md-right">
                <a href="{{ route('users.create') }}" class="btn btn-circle btn-info">
                    <span>{{ translate('Add New User') }}</span>
                </a>
            </div>
        @endcan
	</div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{ translate('Users') }}</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('users.index') }}">
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" name="email" class="form-control" placeholder="{{ translate('Search by Email') }}" value="{{ request('email') }}">
                </div>
                <div class="col-md-4">
                    <input type="text" name="phone" class="form-control" placeholder="{{ translate('Search by Phone') }}" value="{{ request('phone') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">{{ translate('Reset') }}</a>
                </div>
            </div>
        </form>

        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th width="10%">#</th>
                    <th>{{ translate('Name') }}</th>
                    <th>{{ translate('Email') }}</th>
                    <th>{{ translate('Phone') }}</th>
                    <th>{{ translate('Role') }}</th>
                    <th width="10%" class="text-right">{{ translate('Options') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $key => $user)
                    <tr>
                        <td>{{ ($key+1) + ($users->currentPage() - 1)*$users->perPage() }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->role_name ?? '' }}</td>
                        <td class="text-right">
                            @can('edit_user')
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('users.edit', encrypt($user->id)) }}" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                            @endcan
                            @can('delete_user')
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{ route('users.destroy', $user->id) }}" title="{{ translate('Delete') }}">
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
@endsection
