
<nav id="sidebar" aria-label="Main Navigation" style="background-color: #1C3986 !important;">
    <!-- Side Header -->
    <div class="content-header bg-white-5" style="background-color: #4765ab  !important; ">
        <!-- Logo -->
        <a class="font-w600 text-dual" href="{{url('admin/home')}}">
            <span class="smini-hide">
               <span class="font-w700 font-size-h5"><img src="{{asset('images/icon-app.png')}}" width="50px" alt=""> allMasajid</span>
            </span>
        </a>
        <!-- END Logo -->

        <!-- Extra -->
        <div>
            <!-- Close Sidebar, Visible only on mobile screens -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <a class="d-lg-none btn btn-sm btn-dual ml-2" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                <i class="fa fa-fw fa-times"></i>
            </a>
            <!-- END Close Sidebar -->
        </div>
        <!-- END Extra -->
    </div>
    <!-- END Side Header -->

    <!-- Side Navigation -->
    <div class="content-side content-side-full">
        <ul class="nav-main">
{{--            @can('dashboard')--}}
            <li class="nav-main-item">
                <a class="nav-main-link active" href="{{url('admin/home')}}">
                    <i class="nav-main-link-icon si si-speedometer"></i>
                    <span class="nav-main-link-name">Dashboard</span>
                </a>
            </li>
{{--            @endcan--}}
            @can('masajid')
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon fas fa-mosque"></i>
                    <span class="nav-main-link-name">Masajid</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{url('admin/masajid')}}">
                            <i class="nav-main-link-icon fa fa-braille"></i>
                            <span class="nav-main-link-name">All Masajid</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{url('admin/masajid-map-view')}}">
                            <i class="nav-main-link-icon fa fa-map-marker"></i>
                            <span class="nav-main-link-name">Maps View</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{url('admin/masajid/create')}}">
                            <i class="nav-main-link-icon fa fa-plus-circle"></i>
                            <span class="nav-main-link-name">Add Masajids</span>
                        </a>
                    </li>
                </ul>
             </li>
            @endcan

            <li class="nav-main-heading">Management</li>
            @can('dua')
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon fa fa-praying-hands"></i>
                    <span class="nav-main-link-name">Duaas</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{url('admin/dua')}}">
                            <i class="nav-main-link-icon fa fa-braille"></i>
                            <span class="nav-main-link-name">All Duaas</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{url('admin/dua/create')}}">
                            <i class="nav-main-link-icon fa fa-plus-circle"></i>
                            <span class="nav-main-link-name">Duaa</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{url('admin/dua-sub-type/create')}}">
                            <i class="nav-main-link-icon fa fa-plus-circle"></i>
                            <span class="nav-main-link-name">Duaa Sub types</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
            @can('events')
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon si si-energy"></i>
                    <span class="nav-main-link-name">Events</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{url('admin/events')}}">
                            <i class="nav-main-link-icon fa fa-braille"></i>
                            <span class="nav-main-link-name">All events</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{url('admin/events/create')}}">
                            <i class="nav-main-link-icon fa fa-plus-circle"></i>
                            <span class="nav-main-link-name">Add events</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
            @can('announcements')
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon si si-energy"></i>
                    <span class="nav-main-link-name">Announcements</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{url('admin/announcement')}}">
                            <i class="nav-main-link-icon fa fa-braille"></i>
                            <span class="nav-main-link-name">All announcements</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{url('admin/announcement/create')}}">
                            <i class="nav-main-link-icon fa fa-plus-circle"></i>
                            <span class="nav-main-link-name">Add announcements</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
            @can('faq')
                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fa fa-comment-alt"></i>
                        <span class="nav-main-link-name">FAQ</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{url('admin/faq')}}">
                                <i class="nav-main-link-icon fa fa-braille"></i>
                                <span class="nav-main-link-name">All FAQ</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{url('admin/faq/create')}}">
                                <i class="nav-main-link-icon fa fa-plus-circle"></i>
                                <span class="nav-main-link-name">Add FAQ</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('user management')
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon si si-energy"></i>
                    <span class="nav-main-link-name">Users Management</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{url('admin/user')}}">
                            <i class="nav-main-link-icon fa fa-braille"></i>
                            <span class="nav-main-link-name">Backend Users</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{url('admin/app-user')}}">
                            <i class="nav-main-link-icon fa fa-braille"></i>
                            <span class="nav-main-link-name">App Users</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{url('admin/user/create')}}">
                            <i class="nav-main-link-icon fa fa-plus-circle"></i>
                            <span class="nav-main-link-name">Add User</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{url('admin/assign-role')}}">
                            <i class="nav-main-link-icon fa fa-plus-circle"></i>
                            <span class="nav-main-link-name">Assign Role/Permission to User</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{url('admin/assign-masajids')}}">
                            <i class="nav-main-link-icon fa fa-plus-circle"></i>
                            <span class="nav-main-link-name">Assign Masajids to User</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
            @can('role management')
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon si si-energy"></i>
                    <span class="nav-main-link-name">Role Management</span>
                </a>
                <ul class="nav-main-submenu">
{{--                    <li class="nav-main-item">--}}
{{--                        <a class="nav-main-link" href="{{url('admin/role')}}">--}}
{{--                            <i class="nav-main-link-icon fa fa-pen-fancy"></i>--}}
{{--                            <span class="nav-main-link-name">Roles</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{url('admin/permission')}}">
                            <i class="nav-main-link-icon fa fa-pen-fancy"></i>
                            <span class="nav-main-link-name">Permissions</span>
                        </a>
                    </li>
{{--                    <li class="nav-main-item">--}}
{{--                        <a class="nav-main-link" href="{{url('admin/assign-permission-to-role')}}">--}}
{{--                            <i class="nav-main-link-icon fa fa-plus-circle"></i>--}}
{{--                            <span class="nav-main-link-name">Assign permissions to Roles</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                </ul>
            </li>
            @endcan
            @can('contribute')
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon si si-energy"></i>
                    <span class="nav-main-link-name">Contribute</span>
                </a>
                <ul class="nav-main-submenu">

                    <li class="nav-main-item">
                        <a class="nav-main-link active" href="{{url('admin/contribute-with-skills')}}">
                            <i class="nav-main-link-icon fa fa-skiing"></i>
                            <span class="nav-main-link-name">With Skills</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{url('admin/contribute-with-time')}}">
                            <i class="nav-main-link-icon fa fa-clock"></i>
                            <span class="nav-main-link-name">With Time</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
            @can('iqamah')
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon si si-energy"></i>
                    <span class="nav-main-link-name">Iqamah</span>
                </a>
                <ul class="nav-main-submenu">

                    <li class="nav-main-item">
                        <a class="nav-main-link active" href="{{url('admin/iqamah/create')}}">
                            <i class="nav-main-link-icon fa fa-clock"></i>
                            <span class="nav-main-link-name">Add Iqamah</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{url('admin/iqamah')}}">
                            <i class="nav-main-link-icon fa fa-clock"></i>
                            <span class="nav-main-link-name">View Iqamah</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
            @can('utilities')
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon si si-energy"></i>
                    <span class="nav-main-link-name">Utilities</span>
                </a>
                <ul class="nav-main-submenu">

                    <li class="nav-main-item">
                        <a class="nav-main-link active" href="{{url('admin/qr-code')}}">
                            <i class="nav-main-link-icon si si-compass"></i>
                            <span class="nav-main-link-name">QrCode</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{url('admin/skills')}}">
                            <i class="nav-main-link-icon fa fa-skating"></i>
                            <span class="nav-main-link-name">Skills</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{url('admin/settings')}}">
                            <i class="nav-main-link-icon fa fa-gear"></i>
                            <span class="nav-main-link-name">Settings</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
            @can('feedback')
            <li class="nav-main-item">
                <a class="nav-main-link active" href="{{url('admin/feedback')}}">
                    <i class="nav-main-link-icon si si-speedometer"></i>
                    <span class="nav-main-link-name">Feedback</span>
                </a>
            </li>
            @endcan
            @can('dua appeal')
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{url('admin/dua-appeal')}}">
                        <i class="nav-main-link-icon fa fa-praying-hands "></i>
                        <span class="nav-main-link-name">Dua Appeal</span>
                    </a>
                </li>
            @endcan
        </ul>
    </div>
    <!-- END Side Navigation -->
</nav>
<!-- END Sidebar -->
