<!-- resources/views/components/filter-form.blade.php -->
<form class="card" id="filter">
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-2 col-sm-6">
                <label for="sortorder" class="form-label">{{ __('Sort By') }}</label>
                <select id="sortorder" name="sortorder" class="form-control">
                    <option value="">-- {{ __('Sort By') }} --</option>
                    <option value="id_asc" @selected($sortorder == 'id_asc')>
                        {{ __('By Date (Asc)') }}
                    </option>
                    <option value="id_desc" @selected($sortorder == 'id_desc')>
                        {{ __('By Date (Desc)') }}
                    </option>
                    <option value="name_asc" @selected($sortorder == 'name_asc')>
                        {{ __('By Name (Asc)') }}
                    </option>
                    <option value="name_desc" @selected($sortorder == 'name_desc')>
                        {{ __('By Name (Desc)') }}
                    </option>
                </select>
            </div>
            <div class="col-12 col-md-2 col-sm-6">
                 <label for="search" class="form-label">{{ __('Search') }}</label>
                <input type="text" id="search" name="search" class="form-control mb-sm-0 mb-2" placeholder="{{ __('Search') }}"
                    value="{{ $search }}">
            </div>
            <div class="col-12 col-md-2 col-sm-6">
                 <label for="statusx" class="form-label">{{ __('Select Status') }}</label>
                <select name="status" id="statusx" class="form-control">
                    <option value="">-- {{ __('Select Status') }} --</option>
                    <option @selected($status == 'all') value="all">
                        {{ __('All Statuses') }}
                    </option>
                    <option @selected($status == '1') value="1">
                        {{ __('Open') }}
                    </option>
                    <option @selected($status == '2') value="2">
                        {{ __('Repeated claims for settlement/policy') }}
                    </option>
                    <option @selected($status == '3') value="3">
                        {{ __('Under attorney management/handling') }}
                    </option>
                    <option @selected($status == '4') value="4">
                        {{ __('Settlement / policy claims') }}
                    </option>
                    <option @selected($status == '5') value="5">
                        {{ __('Pre-Archive') }}
                    </option>
                    <option @selected($status == '0') value="0">{{ __('Archive') }}</option>
                </select>
            </div>

            <div class="col-12 col-md-2 col-sm-6">
                <label for="start_date" class="form-label">{{ __('Start Date') }}</label>
                <input type="date" id="start_date" name="start_date" class="form-control"
                    value="{{ request('start_date') }}">
            </div>
            <div class="col-12 col-md-2 col-sm-6">
                <label for="end_date" class="form-label">{{ __('End Date') }}</label>
                <input type="date" id="end_date" name="end_date" class="form-control"
                    value="{{ request('end_date') }}">
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-success px-3" name="filter" value="1">
            <i class="fas fa-save"></i>{{ __('Submit') }}
        </button>
        <a href="{{ route('insurance-claims.index') }}" class="btn btn-danger  px-3">
            <i class="fas fa-times"></i> {{ __('Reset') }}
        </a>
    </div>
</form>
@php
    $statusMap = [
        1 => 'Open',
        0 => 'Archive',
        2 => 'Repeated claims for settlement/policy',
        3 => 'Under attorney management/handling',
        4 => 'Settlement / policy claims',
        5 => 'Pre-Archive',
    ];
@endphp
<h3>{{ __('Status') }} -
    {{ isset($status) ? (isset($statusMap[$status]) ? __($statusMap[$status]) : 'Unknown') : __('Open') }}</h3>
<x-admin.paginator-info :items="$lawsuits" class="card-header" />

<div class="row mt-2">
    @foreach ($lawsuits as $lawsuit)
        <div class="col-md-4 col-lg-4 col-xl-4 p-2">
            <div class="card mb-2">
                <div class="card-body">
                    @if ($lawsuit->days_active !== null)
                        <span class="badge {{ $lawsuit->days_active > 89 ? 'bg-danger' : 'bg-success' }} float-end fw-8 fs-14">{{ $lawsuit->days_active }}</span>
                    @endif
                    <h6 class="card-title">{{ __('Insurance Claim No.') }} - {{ $lawsuit->lawsuit_no }}</h6>
                    <h6 class="card-title {{ $lawsuit->color }}">{{ __('Check Date') }} -
                        {{ $lawsuit->payment_date }}</h6>
                    <h6 class="card-title">{{ __('Client Name') }} - {{ $lawsuit->client->name }}</h6>
                    <h6 class="card-title">{{ __('Vehicle No.') }} - @isset($lawsuit->car)
                            {{ $lawsuit->car->license_plate }}
                        @endisset
                    </h6>
                    <h6 class="card-title">{{ __('Invoice Number') }} - {{ $lawsuit->invoice_no }}</h6>
                    @can('insurance_claim_show')
                        <a target="_blank" href="{{ route('insurance-claims.show', [$lawsuit]) }}"
                            class="btn btn-info btn-sm load-circle">
                            <i class="fas fa-plus"></i>
                        </a>
                    @endcan

                    @can('insurance_claim_update')
                        <a target="_blank" href="{{ route('insurance-claims.edit', [$lawsuit]) }}"
                            class="btn btn-success btn-sm load-circle">
                            <i class="fas fa-edit"></i>
                        </a>
                    @endcan

                    @can('insurance_claim_delete')
                        <form action="{{ route('insurance-claims.destroy', [$lawsuit]) }}" method="POST"
                            class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger delete-alert load-circle">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    @endforeach
    <div class="card-footer ">
        {{ $lawsuits->links() }}
    </div>
</div>
