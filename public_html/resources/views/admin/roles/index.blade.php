<x-admin.layout>
	<x-admin.breadcrumb 
		title='Roles'
		:links="[
			['text' => 'Dashboard', 'url' => route('dashboard') ],
            ['text' => 'Roles'],
		]"
        :actions="[
            ['text' => 'New Role', 'icon' => 'fas fa-plus', 'url' => route('roles.create'), 'permission' => 'roles_create', 'class' => 'btn-success '],
            ['text' => 'Dashboard', 'icon' => 'fas fa-technometer', 'url' => auth()->user()->dashboardRoute(), 'class' => 'btn-dark '],
        ]" />
	
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table mb-0">
                <thead>
                    <th>#</th>
                    <th>Name</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach($roles as $key => $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                @can('roles_update')
                                <a href="{{ route('roles.edit', [$role]) }}" class="btn btn-sm btn-success  load-circle">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan

                                @can('roles_delete')
                                <form action="{{ route('roles.destroy', [$role]) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger delete-alert  load-circle">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>        
        </div>
    </div>
    
</x-admin.layout>
