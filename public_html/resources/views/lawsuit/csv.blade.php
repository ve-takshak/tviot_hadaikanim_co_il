<x-admin.layout>
	<x-admin.breadcrumb
			title="Edit Lawsuits"
			:links="[
				['text' => 'Dashboard', 'url' => route('dashboard') ],
                ['text' => 'Lawsuits', 'url' => route('insurance-claims.index')],
                ['text' => 'Edit']
			]"
            :actions="[
                ['text' => 'Create Lawsuits', 'icon' => 'fas fa-plus', 'url' => route('insurance-claims.create'), 'permission' => 'insurance_claim_create', 'class' => 'btn-success '],
                ['text' => 'All Lawsuits', 'icon' => 'fas fa-list', 'url' => route('insurance-claims.index'), 'permission' => 'insurance_claim_access', 'class' => 'btn-dark '],
            ]"
		/>

    <form method="POST" action="{{ route('importCsv.store') }}" class="card shadow-sm" enctype="multipart/form-data">
        @csrf
        <div class="card-body table-responsive">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="">csv<span class="text-danger">*</span></label>
                        <input type="file"  name="csv_file" class="form-control" required >
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i>{{ __('Submit') }} 
            </button>
        </div>
    </form>

</x-admin.layout>
