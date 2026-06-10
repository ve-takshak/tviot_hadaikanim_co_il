<x-admin.layout>
    <x-admin.breadcrumb title="{{ __('Edit Users') }}" :links="[
        ['text' => __('Dashboard'), 'url' => route('dashboard')],
        ['text' => __('Users'), 'url' => route('users.index')],
        ['text' =>  __('Edit')],
    ]" :actions="[
        [
            'text' =>  __('Create New'),
            'permission' => 'users_create',
            'icon' => 'fas fa-plus',
            'url' => route('users.create'),
            'class' => 'btn-danger ',
        ],
        [
            'text' => __('All Users'),
            'icon' => 'fas fa-list',
            'url' => route('users.index'),
            'permission' => 'users_access',
            'class' => 'btn-dark',
        ],
    ]" />


    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('users.update', [$user, 'role_id'=>request('role_id')]) }}" method="POST" class="card shadow-sm"
                enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    @method('PUT')
                    <div class="d-flex">
                        <div class="mr-2">
                            <a href="{{ route('users.users.profile_img.remove', [$user]) }}"
                                class="bg-danger user_profile_remove text-white rounded-pill text-center p-0 border border-white border-3 load-circle"><i
                                    class="fas fa-times"></i></a>
                            <div id="image-preview">
                                <img src="{{ $user->profileImg() }}" alt="image" width="70" class="rounded-circle img-thumbnail">
                            </div>
                        </div>
                        <div class="form-group flex-fill">
                            <label for="">{{ __('Profile Image') }}</label>
                            <input type="file" name="profile_img" class="form-control" id="crop-image">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('User Name') }}<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required="" value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                        <label for="">{{ __('User Email') }} <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required=""
                            value="{{ $user->email }}">
                    </div>
                    <div class="form-group">
                        <label for="">{{ __('User Phone') }} <span class="text-danger">*</span></label>
                        <input type="tel" name="mobile" class="form-control" required=""
                            value="{{ $user->mobile }}">
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">{{ __('Password') }} </label>
                                <input type="password" name="password" class="form-control">
                                <span class="small text-danger">{{ __('Enter password if you want to change') }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">{{ __('Email Verified') }} <span class="text-danger">*</span></label>
                                <select name="email_verified" required="" class="form-control">
                                    <option value="1" {{ $user->email_verified_at ? 'selected' : '' }}>{{ __('Yes') }}</option>
                                    <option value="0" {{ !$user->email_verified_at ? 'selected' : '' }}>{{ __('No') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">{{ __('Role') }} <span class="text-danger">*</span></label>
                        <select name="roles[]" multiple="" required="" class="form-control">
                            <option value="">-- {{ __('Select Role') }} --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-dark">
                        <i class="fas fa-save"></i>{{ __('Submit') }} 
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
        <style>
            .user_profile_remove {
                position: absolute;
                width: 25px;
                height: 25px;
                font-size: 15px;
            }

        </style>
    @endpush
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
