<x-admin.layout>
    <x-admin.breadcrumb title="{{__('Create Appraiser')}}" :links="[
        ['text' => __('Dashboard'), 'url' => route('dashboard')],
        ['text' => __('Appraisers'), 'url' => route('appraiser.index')],
        ['text' => __('Create New')],
    ]" :actions="[
        [
            'text' => __('All Appraisers'),
            'icon' => 'fas fa-list',
            'url' => route('appraiser.index'),
            'permission' => 'appraiser_access',
            'class' => 'btn-dark ',
        ],
    ]" />

<form method="POST" action="{{ route('appraiser.store') }}" class="card shadow-sm" enctype="multipart/form-data">
    @csrf
    <div class="card-body table-responsive">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="">{{ __('Appraiser Name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="">{{ __('Email Contact Person') }} <span class="text-danger">*</span></label>
                    <input name="email" type="text" class="form-control" >
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="">{{ __('Phone') }} <span class="text-danger">*</span></label>
                    <input type="text" name="phone" class="form-control">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="">{{ __('Fax') }}</label>
                    <input type="text" name="fax" class="form-control">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="">{{ __('Link To The Appraiser Website') }}</label>
                    <input type="url" name="link" class="form-control">
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
