<x-admin.layout>
	<x-admin.breadcrumb 
		title='Roles Create'
		:links="[
			['text' => 'Dashboard', 'url' => route('dashboard') ],
            ['text' => 'Roles', 'url' => route('roles.index')],
            ['text' => 'Create'],
		]"
        :actions="[
            ['text' => 'All Roles', 'icon' => 'fas fa-list', 'url' => route('roles.index'), 'permission' => 'roles_access', 'class' => 'btn-success '],
            ['text' => 'Dashboard', 'icon' => 'fas fa-technometer', 'url' => auth()->user()->dashboardRoute(), 'class' => 'btn-dark '],
        ]" />
	
    <div class="row">
        <div class="col-md-5">
            <form method="POST" action="{{ route('roles.store') }}" class="card shadow-sm">
                @csrf
                <div class="card-body table-responsive">
                    <label for="">Name <span class="text-danger">*</span></label>  
                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
    
</x-admin.layout>
