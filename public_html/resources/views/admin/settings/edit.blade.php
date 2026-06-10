<x-admin.layout>
    @push('styles')
        <style>
            input[type=color]{
                padding: 0.15rem;
            }
        </style>
    @endpush
    <x-admin.breadcrumb title="{{ __('Edit Settings') }}" :links="[
        ['text' => __('Dashboard'), 'url' => route('dashboard')],
        ['text' => __('Settings'), 'url' => route('settings.index')],
        ['text' => __('Edit')],
    ]" :actions="[
        [
            'text' => __('All Settings'),
            'icon' => 'fas fa-list',
            'url' => route('settings.index'),
            'class' => 'btn-success ',
            'permission' => 'settings_access'
        ],
    ]" />

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('settings.store') }}" method="POST" class="card shadow-sm" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">{{ __('Name') }}*</label>
                                <input type="text" class="form-control" name="title" value="{{ $setting->title }}"
                                    required placeholder="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">{{ __('Setting key') }}*</label>
                                <input type="text" class="form-control" name="setting_key"
                                    value="{{ $setting->setting_key }}" required placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Setting value') }}*</label>
                        @if (is_array(setting($setting->setting_key)))
                            @foreach (setting($setting->setting_key) as $key => $value)
                                <div class="form-group">
                                    <label>{{ $key }}: </label>
                                    @if (is_array($value))
                                        @foreach ($value as $k => $val)
                                            <div class="ms-3 mb-1">
                                                <b class="text-info">{{ $k }}:</b>
                                                <input type="{{ ($k == 'color') ? 'color' : 'text' }}"
                                                    name="setting_value[{{ $key }}][{{ $k }}]"
                                                    class="form-control" value="{{ $val }}">
                                            </div>
                                        @endforeach
                                    @else
                                        <input type="{{ ($key == 'color') ? 'color' : 'text' }}" name="setting_value[{{ $key }}]"
                                            class="form-control" value="{{ $value }}">
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="d-flex">
                                <input type="text" class="form-control" name="setting_value"
                                    value="{{ $setting->setting_value }}" id="setting_value"
                                    placeholder="">
                                <div class="form-check my-auto ps-4 ms-3">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" id="is_file" value="1">
                                        <span class="text-nowrap">{{ __('Is file') }}</span>
                                    </label>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Remarks') }}</label>
                        <textarea name="remarks" id="remarks" rows="2" class="form-control">{{ $setting->remarks }}</textarea>
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
