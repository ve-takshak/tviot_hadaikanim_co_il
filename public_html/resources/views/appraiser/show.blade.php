<x-admin.layout>
    <x-admin.breadcrumb title="{{ __('Appraiser Show') }}" :links="[
        ['text' => __('Dashboard'), 'url' => route('dashboard')],
        ['text' =>__('Appraisers') , 'url' => route('appraiser.index')],
        ['text' => __('Show')],
    ]" :actions="[
        [
            'text' => __('Create Appraiser'),
            'icon' => 'fas fa-plus',
            'url' => route('appraiser.create'),
            'permission' => 'appraiser_create',
            'class' => 'btn-success ',
        ],
        [
            'text' => __('All Appraisers'),
            'icon' => 'fas fa-list',
            'url' => route('appraiser.index'),
            'permission' => 'appraiser_access',
            'class' => 'btn-dark ',
        ],
    ]" />

    <div class="card">
        <div class="card-header">
            <h5 class="my-auto">{{ $appraiser->name }}</h5>
            <p class="my-auto">{{ __('Email Contact Person') }}- {{ $appraiser->email }}</p>
            <p class="my-auto">{{ __('Phone') }}- {{ $appraiser->phone }}</p>
            <p class="my-auto">{{ __('Fax') }}- {{ $appraiser->fax }}</p>
            <p class="my-auto">{{ __('Link To The Appraiser Website') }}- {{ $appraiser->link }}</p>
           
        </div>
      
        <div class="card-footer">
            @can('appraiser_update')
                <a href="{{ route('appraiser.edit', [$appraiser]) }}" class="btn btn-success  load-circle">
                    <i class="fas fa-edit"></i>{{ __('Edit') }}
                </a>
            @endcan

            @can('appraiser_delete')
                <form action="{{ route('appraiser.destroy', [$appraiser]) }}" method="POST" class="d-inline-block">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger delete-alert  load-circle"><i class="fas fa-trash"></i>
                        {{ __('Delete') }}</button>
                </form>
            @endcan
        </div>
    </div>
</x-admin.layout>
