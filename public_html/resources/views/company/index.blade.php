<x-admin.layout>
    <x-admin.breadcrumb title="{{ __('Insurance Companies') }}" :links="[
        ['text' => __('Dashboard'), 'url' => route('dashboard')],
        ['text' => __('Insurance Companies')],
    ]" :actions="[
        [
            'text' =>  __('Filter'),
            'icon' => 'fas fa-filter',
            'class' => 'btn-secondary ',
            'url' => route('insurance-companies.index', ['filter' => 1]),
        ],
        [
            'text' =>  __('Create New'),
            'permission' => 'inc_companies_create',
            'icon' => 'fas fa-plus',
            'url' => route('insurance-companies.create'),
            'class' => 'btn-danger ',
        ],
    ]" />
    @if (request('filter'))
        <form class="card" id="filter">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-4 col-sm-6">
                        <input type="text" name="search" class="form-control mb-sm-0 mb-2" placeholder="{{ __('Search') }}"
                            value="{{ request('search') }}">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success px-3" name="filter" value="1">
                    <i class="fas fa-save"></i>{{ __('Submit') }} 
                </button>
                <a href="{{ route('insurance-companies.index') }}" class="btn btn-danger  px-3">
                    <i class="fas fa-times"></i> {{ __('Reset') }}
                </a>
            </div>
        </form>
    @endif

    <div class="card shadow-sm">
        <x-admin.paginator-info :items="$companies" class="card-header" />
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Company Name') }}</th>
                        <th>{{ __('Phone') }}</th>
                        <th>{{ __('Fax') }}</th>
                        <th>{{ __('Email Contact Person') }}</th>
                        <th>{{ __('Link To The Company Website') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($companies as $company)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $company->name }}
                            </td>
                            <td>{{ $company->phone }}</td>
                            <td>{{ $company->fax }}</td>
                            <td>{{ $company->email }}</td>
                            <td>{{ $company->link }}</td>
                            <td>
                                @can('inc_companies_show')
                                    <a href="{{ route('insurance-companies.show', [$company]) }}"
                                        class="btn btn-info btn-sm  load-circle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endcan

                                @can('inc_companies_update')
                                    <a href="{{ route('insurance-companies.edit', [$company]) }}"
                                        class="btn btn-success btn-sm  load-circle">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan

                                @can('inc_companies_delete')
                                    <form action="{{ route('insurance-companies.destroy', [$company]) }}" method="POST"
                                        class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger delete-alert  load-circle"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $companies->links() }}
        </div>
    </div>
</x-admin.layout>
