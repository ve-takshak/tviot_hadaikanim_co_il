<x-admin.layout>
    <x-admin.breadcrumb title="{{ __('Create User') }}" :links="[
        ['text' => __('Dashboard'), 'url' => route('dashboard')],
        ['text' => __('Users'), 'url' => route('users.index')],
        ['text' => __('Create')],
    ]" :actions="[
        [
            'text' => __('All Users'),
            'icon' => 'fas fa-list',
            'url' => route('users.index'),
            'permission' => 'users_access',
            'class' => 'btn-dark ',
        ],
    ]" />


    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('users.store',['role_id'=>request('role_id')]) }}" method="POST" class="card shadow-sm"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mr-2">
                            <div id="image-preview"></div>
                        </div>
                        <div class="form-group flex-fill">
                            <label for="">{{ __('Profile Image') }}</label>
                            <input type="file" name="profile_img" class="form-control" id="crop-image">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('User Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required="">
                    </div>
                    <div class="form-group">
                        <label for="">{{ __('User Email') }} <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required="">
                    </div>
                    <div class="form-group">
                        <label for="">{{ __('User Phone') }}  <span class="text-danger">*</span></label>
                        <input type="tel" name="mobile" class="form-control" required="">
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">{{ __('Password') }}  <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" required="">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" required="">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">{{ __('Email Verified') }} <span class="text-danger">*</span></label>
                                <select name="email_verified" required="" class="form-control">
                                    <option value="1">{{ __('Yes') }}</option>
                                    <option value="0">{{ __('No') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">{{ __('Role') }} <span class="text-danger">*</span></label>
                        <select name="roles[]" multiple="" required="" class="form-control">
                            <option value="">-- {{ __('Select Role') }} --</option>
                            @foreach ($roles as $role)
                                <option @selected($role->id == request('role_id')) value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> {{ __('Submit') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            var previewImg = {
                width: '70px',
                rounded: '50px',
            };
            imageCropper('crop-image', 1 / 1, previewImg);
        </script>
    @endpush
</x-admin.layout>
