<x-admin.layout>
	<x-admin.breadcrumb
		title='Queries'
		:links="[
			['text' => 'Dashboard', 'url' => route('dashboard') ],
            ['text' => 'Queries'],
		]"
        :actions="[
            ['text' => 'Dashboard', 'icon' => 'fas fa-technometer', 'url' => auth()->user()->dashboardRoute(), 'class' => 'btn-dark '],
        ]" />

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table mb-0">
                <thead>
                    <th>#</th>
                    <th>Title</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Subject</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach($queries as $key => $query)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $query->title }}</td>
                            <td>{{ $query->name }}</td>
                            <td>{{ $query->email }}</td>
                            <td>{{ $query->mobile }}</td>
                            <td>{{ $query->subject }}</td>
                            <td class="text-nowrap">
                                @can('queries_show')
                                <a href="{{ route('queries.show', [$query]) }}" class="btn btn-sm btn-info  load-circle">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endcan

                                @can('queries_delete')
                                <form action="{{ route('queries.destroy', [$query]) }}" method="POST" class="d-inline-block">
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
        <div class="card-footer">
            {{ $queries->links() }}
        </div>
    </div>

</x-admin.layout>
