<x-admin.layout>
    <x-admin.breadcrumb 
        title="{{ __('Insurance Claims') }}" 
        :links="[['text' => __('Dashboard'), 'url' => route('dashboard')], ['text' => __('Insurance Claims')]]" 
        :actions="[
            [
                'text' => __('Export'),
                'icon' => 'fas fa-file-export',
                'permission' => 'insurance_claim_create', 
                'class' => 'btn-primary',
                'attributes' => [
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#exportModal'
                ]
            ],
            [
                'text' => __('Create New'),
                'permission' => 'insurance_claim_create', 
                'icon' => 'fas fa-plus',
                'url' => route('insurance-claims.create'),
                'class' => 'btn-danger',
            ]
        ]" 
    />

    <x-lawsuit-data :lawsuits="$lawsuits" :sortorder="request('sortorder')" :search="request('search')" :status="request('status')" />

    <!-- Export Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">{{ __('Export Insurance Claims') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('insurance-claims.export') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="from_date" class="form-label">{{ __('From date') }}</label>
                            <input type="date" class="form-control" id="from_date" name="from_date" required onchange="setMinDate()">
                        </div>
                        <script>
                            function setMinDate() {
                                document.getElementById('to_date').min = document.getElementById('from_date').value;
                            }
                        </script>
                        <div class="mb-3">
                            <label for="to_date" class="form-label">{{ __('To date') }}</label>
                            <input type="date" class="form-control" id="to_date" name="to_date" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Export') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin.layout>
