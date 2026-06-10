<x-admin.layout>
	<x-admin.breadcrumb
			title="{{ __('User Detail') }}"
			:links="[
				['text' => __('Dashboard'), 'url' => route('dashboard') ],
                ['text' => __('Users'), 'url' => route('users.index')],
                ['text' => __('Detail')]
			]"
            :actions="[
                ['text' => __('Create New'), 'permission' => 'users_create', 'icon' => 'fas fa-plus', 'url' => route('users.create',['role_id'=>request('role_id')]), 'class' => 'btn-danger '],
                ['text' => __('All Users'), 'icon' => 'fas fa-list', 'url' => route('users.index',['role_id'=>request('role_id')]), 'permission' => 'users_access', 'class' => 'btn-dark '],
            ]"
		/>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0 text-dark">{{ __('User Information') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td><b>{{ __('Name') }}:</b></td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td><b>{{ __('Email') }}:</b></td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td><b>{{ __('Phone') }}:</b></td>
                            <td>{{ $user->mobile }}</td>
                        </tr>
                        <tr>
                            <td><b>{{ __('Email Verified') }}</b></td>
                            <td>{{ $user->email_verified_at ? date('d-M-y h:i A', strtotime($user->email_verified_at)) : '' }}</td>
                        </tr>
                        <tr>
                            <td><b>{{ __('Role') }}:</b></td>
                            <td>{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                        </tr>
                        <tr>
                            <td><b>{{ __('Created') }}:</b></td>
                            <td>{{ date('d-M-y h:i A', strtotime($user->created_at)) }}</td>
                        </tr>

                        <tr>
                            <td colspan="2" class="text-center">
                                @can('user_update')
                                <a href="{{ route('users.edit', [$user,'role_id'=>request('role_id')]) }}" class="btn btn-success px-3">
                                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                                </a>
                                @endcan

                                @can('login_to_user')
                                <a href="{{ route('login-to', [$user]) }}" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt"></i> {{ __('Login To') }}
                                </a>
                                @endcan
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>


</x-admin.layout>
