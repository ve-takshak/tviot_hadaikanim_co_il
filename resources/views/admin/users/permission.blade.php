<x-admin.layout>
    @push('styles')
        <style>
            .permissions .list-group-item { border-radius: 0px; }
            .permissions > ul:nth-child(even) .list-group-item{ background-color: #e4e4e4; }
        </style>
    @endpush
	<x-admin.breadcrumb
			title="{{__('User Permissions')}}"
			:links="[
				['text' => __('Dashboard'), 'url' => route('dashboard') ],
                ['text' => __('Users'), 'url' => route('users.index')],
                ['text' =>  __('Permissions')]
			]"
            :actions="[
                ['text' =>  __('All Users'), 'icon' => 'fas fa-list', 'url' => route('users.index'), 'permission' => 'users_access', 'class' => 'btn-dark '],
            ]"
		/>

    <div class="row">
        @foreach($roles as $role)
            <div class="col-md-6">
                <form action="{{ route('permissions.roles.update', [$role]) }}" method="POST" class="card shadow-sm">
                    @csrf
                    <div class="card-header bg-light border-bottom border-secondary pointer text-capitalize font-weight-bold font-18" data-bs-toggle="collapse" data-bs-target="#{{ $role->name }}">
                        {{ $role->name }}
                    </div>
                    <div class="card-body permissions" id="{{ $role->name }}">
                        @foreach($permissions as $key => $permission)
                            <ul class="list-group rounded-0 mb-2">
                                <li class="list-group-item d-flex justify-content-between">
                                    <div class="form-check-inline my-auto flex-fill pr-2">
                                        <label class="form-check-label d-flex">
                                            <div class="my-auto me-1">
                                                <input type="checkbox" name="permissions[]" class="form-check-input" value="{{ $permission->id }}" {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }} >
                                            </div>
                                            <div class="my-auto" data-bs-toggle="popover" data-bs-content="{{ $permission->name }}">
                                                <div>{{ __($permission->title) }}</div>
                                                <span class="small">{{ $permission->hint }}</span>
                                            </div>
                                        </label>
                                    </div>

                                    @if($permission->children->count() > 0)
                                    <div class="my-auto font-18 pointer" data-bs-toggle="collapse" data-bs-target="#permission{{ $role->id.$key }}">
                                        <i class="fas fa-caret-square-down"></i>
                                    </div>
                                    @endif
                                </li>
                                @if($permission->children->count() > 0)
                                    <ul class="list-group ml-4 collapse" id="permission{{ $role->id.$key }}">
                                        @foreach($permission->children as $permission2)
                                            <li class="list-group-item">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label d-flex">
                                                        <div class="my-auto me-1">
                                                            <input type="checkbox" name="permissions[]" class="form-check-input" value="{{ $permission2->id }}" {{ in_array($permission2->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }} >
                                                        </div>
                                                        <div class="my-auto" data-bs-toggle="popover" data-bs-content="{{ $permission2->name }}">
                                                            <div>{{ __($permission2->title) }}</div>
                                                            <span class="small">{{ $permission2->hint }}</span>
                                                        </div>
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </ul>
                        @endforeach

                        @can('permissions_roles_update')
                            <button type="submit" class="btn btn-success" name="role_id" value="{{ $role->id }}">
                                <i class="fas fa-save"></i>{{ __('Update') }}
                            </button>
                        @endcan
                    </div>
                </form>
            </div>
        @endforeach
    </div>

    @push('scripts')
        <script>
            $(document).ready(function($) {
                $('[data-toggle="popover"]').popover();
            });
        </script>
    @endpush
</x-admin.layout>
