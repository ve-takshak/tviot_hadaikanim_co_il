<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Hebrew:wght@100..900&display=swap');

        body {
            font-family: 'Noto Sans Hebrew', sans-serif;
        }

        .fw-600 {
            font-weight: 600;
        }
    </style>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{ url('/') }}">
                <x-application-logo class="w-25 h-25 fill-current text-primary" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div class="text-center mb-4">
            <a class="btn btn-outline-primary mb-3 w-100" href="{{ route('login') }}">{{ __('Login As Admin/Agent') }}</a>
            <h4 class="mb-4">{{ __('Client Login') }}</h4>
        </div>

        <form method="POST" action="{{ route('client.logindo') }}">
            @csrf

            <!-- Identity Card -->
            <div class="mb-3">
                <label for="tz" class="form-label">{{ __('Identity Card') }}</label>
                <input id="tz" class="form-control" type="text" name="tz" value="" required
                    autofocus />
            </div>

            <!-- Vehicle Number -->
            <div class="mb-3">
                <label for="vno" class="form-label">{{ __('Vehicle Number') }}</label>
                <input id="vno" class="form-control" type="text" name="vno" required />
            </div>

            <!-- Login Button -->
            <div class="d-flex justify-content-end">
                <x-button class="btn btn-primary fw-600">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
