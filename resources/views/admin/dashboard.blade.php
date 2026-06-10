<x-admin.layout>
    <x-admin.breadcrumb title="{{ __('Dashboard') }}" :actions="[]" :back="[
        'show' => false,
    ]" />
    @can('insurance_claim_access')
       <x-lawsuit-data :lawsuits="$lawsuits" :sortorder="request('sortorder')" :search="request('search')" :status="request('status')" />

    @endcan
</x-admin.layout>
