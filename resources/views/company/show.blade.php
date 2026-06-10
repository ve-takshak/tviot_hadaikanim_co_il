<x-admin.layout>
    <x-admin.breadcrumb title="{{ __('Insurance Companies Show') }}" :links="[
        ['text' => __('Dashboard'), 'url' => route('dashboard')],
        ['text' => __('Insurance Companies'), 'url' => route('insurance-companies.index')],
        ['text' => __('Show')],
    ]" :actions="[
        [
            'text' => __('Create Insurance Companies'),
            'icon' => 'fas fa-plus',
            'url' => route('insurance-companies.create'),
            'permission' => 'inc_companies_create',
            'class' => 'btn-success ',
        ],
        [
            'text' => __('All Insurance Companies'),
            'icon' => 'fas fa-list',
            'url' => route('insurance-companies.index'),
            'permission' => 'inc_companies_access',
            'class' => 'btn-danger ',
        ],
    ]" />

    <div class="card">
        <div class="card-header">
            <h4 class="my-auto">{{ $insuranceCompany->name }}</h4>
            <h5 class="my-auto">{{ __('Email Contact Person') }} - {{ $insuranceCompany->email }}</h5>
            <h5 class="my-auto">{{ __('Phone') }} - {{ $insuranceCompany->phone }}</h5>
            <h5 class="my-auto">{{ __('Fax') }} - {{ $insuranceCompany->fax }}</h5>
            <h5 class="my-auto">{{ __('Link To The Company Website') }} - {{ $insuranceCompany->link }}</h5>
           
        </div>
      
        <div class="card-footer">
            @can('inc_companies_update')
                <a href="{{ route('insurance-companies.edit', [$insuranceCompany]) }}" class="btn btn-success  load-circle">
                    <i class="fas fa-edit"></i>{{ __('Edit') }}
                </a>
            @endcan

            @can('inc_companies_delete')
                <form action="{{ route('insurance-companies.destroy', [$insuranceCompany]) }}" method="POST" class="d-inline-block">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger delete-alert  load-circle"><i class="fas fa-trash"></i>
                        {{ __('Delete') }}</button>
                </form>
            @endcan
        </div>
    </div>
</x-admin.layout>
