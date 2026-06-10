<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled fw-bold" id="side-menu">
                {{-- adash-dashboard --}}
                <li class="menu-title">{{ __('Admin Main') }}</li>
                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="fas fa-home"></i>
                        <span> {{ __('Dashboard') }}</span>
                    </a>
                </li>

                {{-- end adash-dashboard --}}

                @can('inc_companies_access')
                    <li>
                        <a href="{{ route('insurance-companies.index') }}" class="waves-effect">
                            <i class="fas fa-building"></i>
                            <span>{{ __('Insurance Companies') }}</span>
                        </a>
                    </li>
                @endcan
                @can('agent_access')
                    <li>
                        <a href="{{ route('users.index', ['role_id' => 3]) }}" class="waves-effect">
                            <i class="fas fa-user-tie"></i>
                            <span>{{ __('All Agents') }}</span>
                        </a>
                    </li>
                @endcan
                @can('appraiser_access')
                    <li>
                        <a href="{{ route('appraiser.index') }}" class="waves-effect">
                            <i class="fas fa-suitcase"></i>
                            <span>{{ __('Appraisers') }}</span>
                        </a>
                    </li>
                @endcan
                @can('insurance_claim_access')
                    <li>
                        <a href="{{ route('insurance-claims.index') }}" class="waves-effect">
                            <i class="fas fa-car-crash"></i>
                            <span>{{ __('Insurance Claims') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('calendar') }}" class="waves-effect">
                            <i class="fas fa-calendar"></i>
                            <span>{{ __('Calendar') }}</span>
                        </a>
                    </li>
                @endcan
                @canany(['roles_access', 'permissions_access', 'users_access', 'client_access', 'employee_access',
                    'admin_access', 'lawyer_access'])
                    <li class="menu-title">{{ __('Manage Users') }}</li>
                    {{-- @can('roles_access')
                        <li>
                            <a href="{{ route('roles.index') }}" class="waves-effect">
                                <i class="fas fa-users-cog"></i>
                                <span>All Roles</span>
                            </a>
                        </li>
                    @endcan --}}

                    @can('permissions_access')
                        <li>
                            <a href="{{ route('permissions.index') }}" class="waves-effect">
                                <i class="fas fa-user-shield"></i>
                                <span>{{ __('All Permissions') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('client_access')
                        <li>
                            <a href="{{ route('users.index', ['role_id' => 5]) }}" class="waves-effect">
                                <i class="fas fa-user-plus"></i>
                                <span>{{ __('All Clients') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('lawyer_access')
                        <li>
                            <a href="{{ route('users.index', ['role_id' => 6]) }}" class="waves-effect">
                                <i class="fas fa-gavel"></i>
                                <span>{{ __('All Lawyers') }}</span>
                            </a>
                        </li>
                        @endcan
                    @can('employee_access')
                        <li>
                            <a href="{{ route('users.index', ['role_id' => 2]) }}" class="waves-effect">
                                <i class="fas fa-users"></i>
                                <span>{{ __('All Employees') }}</span>
                            </a>
                        </li>
                        @endcan
                        @if (auth()->user()->isAdmin())
                            <li>
                                <a href="{{ route('users.index', ['role_id' => 1]) }}" class="waves-effect">
                                    <i class="fas fa-user-lock"></i>
                                    <span>{{ __('All Admins') }}</span>
                                </a>
                            </li>
                        @endif
                @endcanany


                <li class="menu-title">{{ __('Manage Account') }}</li>
                @can('settings_create')
                    <li>
                        <a href="{{ route('settings.index') }}" class=" waves-effect">
                            <i class="fas fa-tools"></i>
                            <span>{{ __('Settings') }}</span>
                        </a>
                    </li>
                @endcan

                <li>
                    <a href="{{ route('profile.edit') }}" class=" waves-effect">
                        <i class="fas fa-user"></i>
                        <span>{{ __('Update Profile') }}</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class=" waves-effect"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fas fa-power-off"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </li>



            </ul>
        </div>
    </div>
</div>
