<x-admin.layout>
	<x-admin.breadcrumb
			title="{{ __('Edit Insurance Companies') }}"
			:links="[
				['text' => __('Dashboard'), 'url' => route('dashboard') ],
                ['text' => __('Insurance Companies'), 'url' => route('insurance-companies.index')],
                ['text' => __('Edit')]
			]"
            :actions="[
                ['text' => __('Create Insurance Companies'), 'icon' => 'fas fa-plus', 'url' => route('insurance-companies.create'), 'permission' => 'inc_companies_create', 'class' => 'btn-success '],
                ['text' => __('All Insurance Companies'), 'icon' => 'fas fa-list', 'url' => route('insurance-companies.index'), 'permission' => 'inc_companies_access', 'class' => 'btn-danger'],
            ]"
		/>

    <form method="POST" action="{{ route('insurance-companies.update', [$insuranceCompany]) }}" class="card shadow-sm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body table-responsive">
            
            <div class="row">
                <div class="col-sm-6">
                <div class="form-group">
                    <label for="">{{ __('Company Name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required value="{{ $insuranceCompany->name }}">
                </div>
                </div>
            
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Email Contact Person') }} <span class="text-danger">*</span></label>
                        <input name="email" value="{{$insuranceCompany->email}}" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Phone') }} <span class="text-danger">*</span></label>
                        <input type="text" value="{{$insuranceCompany->phone}}" name="phone" class="form-control" >
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Fax') }}</label>
                        <input type="text" value="{{$insuranceCompany->fax}}" name="fax" class="form-control" >
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Link To The Company Website') }}</label>
                        <input type="url" value="{{$insuranceCompany->link}}" name="link" class="form-control" >
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> {{ __('Submit') }} 
            </button>
        </div>
    </form>

</x-admin.layout>
