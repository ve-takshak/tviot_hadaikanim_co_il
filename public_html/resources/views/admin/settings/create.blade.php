<x-admin.layout>
    <x-admin.breadcrumb title="{{ __('New Setting') }}" :links="[
        ['text' => __('Dashboard') , 'url' => route('dashboard')],
        ['text' => __('Settings') , 'url' => route('settings.index')],
        ['text' => __('Create') ],
    ]" :actions="[
        [
            'text' => __('All Settings'),
            'icon' => 'fas fa-list',
            'url' => route('settings.index'),
            'class' => 'btn-danger ',
            'permission' => 'settings_access'
        ],
    ]" />

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('settings.store') }}" method="POST" class="card" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">{{ __('Name') }}*</label>
                                <input type="text" class="form-control" name="title" required
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">{{ __('Setting key') }}*</label>
                                <input type="text" class="form-control" name="setting_key" required
                                    placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Setting value') }}*</label>
                        <div class="d-flex">
                            <input type="text" class="form-control" name="setting_value" id="setting_value" required
                                placeholder="">
                            <div class="form-check my-auto ps-4 ms-3">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" id="is_file" value="1">
                                    <span class="text-nowrap">{{ __('Is file') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Remarks') }}</label>
                        <textarea name="remarks" id="remarks" rows="2" class="form-control"></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-successpx-3">
                        <i class="fas fa-save"></i>{{ __('Submit') }} 
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $("#is_file").change(function() {
                    $("#setting_value").attr('type', $(this).is(":checked") ? 'file' : 'text');
                });
            });
        </script>
    @endpush
</x-admin.layout>
