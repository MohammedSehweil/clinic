<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                @lang('menus.backend.sidebar.general')
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/dashboard')) }}"
                   href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon icon-speedometer"></i> @lang('menus.backend.sidebar.dashboard')
                </a>
            </li>

            <li class="nav-title">
                @lang('menus.backend.sidebar.system')
            </li>


            @if(canRegisterToClinic($logged_in_user))
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/registration*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/registration*')) }}"
                       href="#">
                        <i class="nav-icon icon-user"></i> Registration

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/registration/*')) }}"
                               href="{{ route('admin.registration.index') }}">
                                Registration

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>
            @endif


            @if(canSeeClinics($logged_in_user))
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/clinic*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/clinic*')) }}"
                       href="#">
                        <i class="nav-icon icon-user"></i> Clinic

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/clinic/*')) }}"
                               href="{{ route('admin.clinic.index') }}">
                                Clinics

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(canSeeLabs($logged_in_user))
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/lab*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/lab*')) }}"
                       href="#">
                        <i class="nav-icon icon-user"></i> Laboratory

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/lab/*')) }}"
                               href="{{ route('admin.lab.index') }}">
                                Laboratories

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>
            @endif


            @if(canSeeDoctors($logged_in_user))
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/doctor*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/doctor*')) }}"
                       href="#">
                        <i class="nav-icon icon-user"></i> Doctors

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/doctor/*')) }}"
                               href="{{ route('admin.doctor.index') }}">
                                Doctors

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(canSeePrivateDoctors($logged_in_user))
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/private-doctor*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/private-doctor*')) }}"
                       href="#">
                        <i class="nav-icon icon-user"></i> Private Doctors

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/private-doctor/*')) }}"
                               href="{{ route('admin.private-doctor.index') }}">
                                Private Doctors

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>
            @endif



            @if(canSeeNurses($logged_in_user))
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/nurse*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/nurse*')) }}"
                       href="#">
                        <i class="nav-icon icon-user"></i> Nurses

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/nurse/*')) }}"
                               href="{{ route('admin.nurse.index') }}">
                                Nurses

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>
            @endif


            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/patient*'), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/patient*')) }}"
                   href="#">
                    <i class="nav-icon icon-user"></i> Patients

                    @if ($pending_approval > 0)
                        <span class="badge badge-danger">{{ $pending_approval }}</span>
                    @endif
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/patient/*')) }}"
                           href="{{ route('admin.patient.index') }}">
                            Patients

                            @if ($pending_approval > 0)
                                <span class="badge badge-danger">{{ $pending_approval }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>

            @if ($logged_in_user->isAdmin() and isAdmin())
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/auth*')) }}"
                       href="#">
                        <i class="nav-icon icon-user"></i> @lang('menus.backend.access.title')

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/user*')) }}"
                               href="{{ route('admin.user.index') }}">
                                @lang('labels.backend.access.users.management')

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/role*')) }}"
                               href="{{ route('admin.role.index') }}">
                                @lang('labels.backend.access.roles.management')
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            <li class="divider"></li>
            @if(isAdmin())
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/log-viewer*')) }}"
                       href="#">
                        <i class="nav-icon icon-list"></i> @lang('menus.backend.log-viewer.main')
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer')) }}"
                               href="{{ route('log-viewer::dashboard') }}">
                                @lang('menus.backend.log-viewer.dashboard')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer/logs*')) }}"
                               href="{{ route('log-viewer::logs.list') }}">
                                @lang('menus.backend.log-viewer.logs')
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div><!--sidebar-->
