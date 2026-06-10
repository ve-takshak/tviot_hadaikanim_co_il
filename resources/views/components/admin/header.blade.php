<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box d-flex">
                <a href="{{ url('/') }}" class="logo logo-light text-white m-auto">
                    <span class="logo-sm">
                        <h2 class="mb-0">{{ str()->of(setting('site_short_name'))->substr(0, 2) }}</h2>
                    </span>
                    <span class="logo-lg mb-0">
                        <h2 class="mb-0 d-flex">
                            <span>{{ str()->of(setting('site_name'))->substr(0, 12) }}</span>
                        </h2>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="fas fa-bars"></i>
            </button>

        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block dropstart">
                <button disabled type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ auth()->user()->profileImg() }}"
                        alt="Header Avatar">
                </button>
                {{-- <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                        <i class="mdi mdi-account-circle font-size-17 align-middle mr-1"></i>
                        <i class="fas fa-home mr-1"></i> 
                        {{ __('Dashboard') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="mdi mdi-lock-open-outline font-size-17 align-middle mr-1"></i>
                        <i class="fas fa-user mr-1"></i>
                       {{ __('My Profile') }}
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="bx bx-power-off font-size-17 align-middle mr-1 text-danger"></i>
                        <i class="fas fa-power-off mr-1"></i> 
                       {{ __('Logout') }}
                    </a> 
                   
                </div> --}}
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>

            <div class="dropdown d-none d-lg-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="fas fa-arrows-alt"></i>
                </button>
            </div>
            <div class="dropdown  d-lg-inline-block">
                <form method="POST" action="{{ route('toggle-mode') }}">
                    @csrf
                    <button type="submit" class="form-check-label btn header-item noti-icon waves-effect d-flex mb-0"
                        id=""> <i class="fas  {{ $dark_mode == true ? 'fa-sun' : 'fa-moon' }} m-auto"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
