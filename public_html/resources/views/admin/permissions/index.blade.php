<x-admin.layout>
    <x-admin.breadcrumb title="{{__('Permissions')}}" :links="[['text' => __('Dashboard'), 'url' => route('dashboard')], ['text' => __('Permissions')]]" :actions="[
        [
            'text' => __('Roles & Permissions'),
            'icon' => 'fas fa-user-shield',
            'url' => route('permissions.roles.index'),
            'class' => 'btn-danger',
        ],
    ]" />

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table mb-0">
                <thead>
                    <th>#</th>
                    <th>{{ __('Parent') }}</th>
                    <th>{{ __('Action') }}</th>
                </thead>
                <tbody>
                    @foreach ($permissions as $key => $permission)
                        <tr class="{{ $key % 2 ? 'table-success' : '' }}">
                            <td>{{ $key + 1 }}</td>
                            <td>
                                {{ __($permission->title) }}
                                <div class="small">{{ $permission->name }}</div>
                            </td>
                            <td>
                                @can('permissions_update')
                                    <a href="{{ route('permissions.edit', [$permission]) }}"
                                        class="btn btn-sm btn-success  load-circle">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan

                                @can('permissions_delete')
                                    <form action="{{ route('permissions.destroy', [$permission]) }}" method="POST"
                                        class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-danger delete-alert  load-circle">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endcan
                            </td>
                            {{-- <td>{{ $permission->hint }}</td> --}}
                        </tr>

                        @foreach ($permission->children as $key2 => $permission2)
                            <tr class="table-sm {{ $key % 2 ? 'table-info' : '' }}">
                                <td class="pl-4">{{ $key + 1 . '.' . ($key2 + 1) }}</td>
                                <td class="pl-4">
                                    {{ __($permission2->title) }}
                                    <span class="small">({{ $permission2->name }})</span>
                                </td>
                                <td class="pl-3">
                                    @can('permissions_update')
                                        <a href="{{ route('permissions.edit', [$permission2]) }}"
                                            class="btn btn-sm btn-success  load-circle">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan

                                    @can('permissions_delete')
                                        <form action="{{ route('permissions.destroy', [$permission2]) }}" method="POST"
                                            class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-danger delete-alert  load-circle">
                                                <i class="fas fa-trash p"></i>
                                            </button>
                                        </form> 
                                    @endcan
                                </td>
                                {{-- <td>{{ $permission->hint }}</td> --}}
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-admin.layout>
