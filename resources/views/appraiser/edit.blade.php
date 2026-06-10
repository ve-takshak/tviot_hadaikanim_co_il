<x-admin.layout>
    <x-admin.breadcrumb :title="__('Edit Appraiser')" :links="[
        ['text' => __('Dashboard'), 'url' => route('dashboard')],
        ['text' => __('Appraisers'), 'url' => route('appraiser.index')],
        ['text' => __('Edit')],
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

    <form method="POST" action="{{ route('appraiser.update', [$appraiser]) }}" class="card shadow-sm"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body table-responsive">

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Appraiser Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required
                            value="{{ $appraiser->name }}">
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Email Contact Person') }} <span
                                class="text-danger">*</span></label>
                        <input name="email" value="{{ $appraiser->email }}" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Phone') }} <span class="text-danger">*</span></label>
                        <input type="text" value="{{ $appraiser->phone }}" name="phone" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Fax') }}</label>
                        <input type="text" value="{{ $appraiser->fax }}" name="fax" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Link To The Appraiser Website') }}</label>
                        <input type="url" value="{{ $appraiser->link }}" name="link" class="form-control">
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
