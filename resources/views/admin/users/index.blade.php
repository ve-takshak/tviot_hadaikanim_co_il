<x-admin.layout>
    <x-admin.breadcrumb title="{{ __('All ' . $roleName) }}" :links="[['text' => __('Dashboard'), 'url' => route('dashboard')], ['text' => __($roleName)]]" :actions="[
        [
            'text' => __('Create New'),
            'permission' => Auth::user()->getCreatePermissionByRoleId(request('role_id')),
            'icon' => 'fas fa-plus',
            'url' => route('users.create', ['role_id' => request('role_id')]),
            'class' => 'btn-danger ',
        ],
    ]" />

    <form class="card" id="filter">
        <div class="card-body">
            <div class="row">
                <input type="hidden" name="role_id" value="{{ request('role_id') }}">
                <div class="col-12 col-md-4 col-sm-6">
                    <input type="text" name="search" class="form-control mb-sm-0 mb-2"
                        placeholder="{{ __('Search') }}" value="{{ request('search') }}">
                </div>
                {{-- <div class="col-12 col-md-4 col-sm-6">
                        <select name="role_id" class="form-control">
                            <option value="">-- {{ __('Select Role') }} --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div> --}}
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success px-3" name="filter" value="1">
                <i class="fas fa-save"></i>{{ __('Submit') }}
            </button>
            <a href="{{ route('users.index', ['role_id' => request('role_id')]) }}" class="btn btn-danger  px-3">
                <i class="fas fa-times"></i>{{ __('Reset') }}
            </a>
        </div>
    </form>

    <div class="card shadow-sm">
        <x-admin.paginator-info :items="$users" class="card-header" />
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Phone') }}</th>
                        <th>{{ __('Role') }}</th>
                        {{-- <th>Verified</th> --}}
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $user->name }}

                                <a href="{{ route('users.status-toggle', [$user]) }}"
                                    class="badge bg-{{ $user->status ? 'success' : 'danger' }} fs-12">
                                    {{ $user->status ? 'Active' : 'In-active' }}
                                </a>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->mobile }}</td>
                            <td>{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                            {{-- <td>{{ $user->email_verified_at ? date('d-M-y h:i A', strtotime($user->email_verified_at)) : '' }}
                            </td> --}}
                            <td>

                                @if (Auth::user()->hasShowPermission(request('role_id')))
                                    <a href="{{ route('users.show', [$user, 'role_id' => request('role_id')]) }}"
                                        class="btn btn-info btn-sm  load-circle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endif
                                @if (Auth::user()->hasEditPermission(request('role_id')))
                                    <a href="{{ route('users.edit', [$user, 'role_id' => request('role_id')]) }}"
                                        class="btn btn-success btn-sm  load-circle">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                                @if (Auth::user()->hasDeletePermission(request('role_id')))
                                    @if ($user->id != 1)
                                        <form
                                            action="{{ route('users.destroy', [$user, 'role_id' => request('role_id')]) }}"
                                            method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger delete-alert  load-circle"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $users->links() }}
        </div>
    </div>
</x-admin.layout>
