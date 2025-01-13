<!-- Page Sidebar Start-->
<div class="page-sidebar">
    <div class="main-header-left d-none d-lg-block">
        <div class="logo-wrapper">
            <a href="{{ route('home') }}">
                <img class="d-none d-lg-block blur-up lazyloaded"
                    src="{{ asset('assets/images/dashboard/kleancor_logo.png') }}" alt="" width="200">
            </a>
        </div>
    </div>
    <div class="sidebar custom-scrollbar">
        <a href="javascript:void(0)" class="sidebar-back d-lg-none d-block"><i class="fa fa-times"
                aria-hidden="true"></i></a>
        <ul class="sidebar-menu">
            <li class="{{ Active::checkRoute(['home']) }}">
                <a class="sidebar-header {{ Active::checkRoute(['home']) }}" href="{{ route('home') }}">
                    <i data-feather="home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- <li class="{{ Active::checkRoute(['jobs.index']) }}">
                <a class="sidebar-header {{ Active::checkRoute(['jobs.index']) }}" href="{{ route('jobs.index') }}">
                    <i class="fa-solid fa-briefcase"></i>
                    <span>Manage Jobs</span>
                </a>
            </li>

            <li>
                <a class="sidebar-header" href="#">
                    <i class="fa-regular fa-calendar-check"></i>
                    <span>Applications</span>
                </a>
            </li> -->

            <li class="{{ Active::checkRoute(['users.index', 'users.create']) }}">
                <a class="sidebar-header" href="javascript:void(0)">
                    <i class="fas fa-users"></i>
                    <span>Manage Users</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>

                <ul class="sidebar-submenu">
                    <li class="{{ Active::checkRoute('users.index') }}">
                        <a href="{{ route('users.index') }}">
                            <i class="fa fa-user"></i>
                            <span>User List</span>
                        </a>
                    </li>

                    <li class="{{ Active::checkRoute('users.create') }}">
                        <a href="{{ route('users.create') }}">
                            <i class="fa fa-user"></i>
                            <span>Add User</span>
                        </a>
                    </li>
                </ul>
            </li>


            <li class="{{ Active::checkRoute(['categories.index', 'categories.create']) }}">
                <a class="sidebar-header" href="javascript:void(0)">
                    <i class="fas fa-th-list"></i>
                    <span>Manage Category</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>

                <ul class="sidebar-submenu">
                    <li class="{{ Active::checkRoute('categories.index') }}">
                        <a href="{{ route('categories.index') }}">
                            <i class="fa fa-circle"></i>
                            <span>Category List</span>
                        </a>
                    </li>

                    <li class="{{ Active::checkRoute('categories.create') }}">
                        <a href="{{ route('categories.create') }}">
                            <i class="fa fa-circle"></i>
                            <span>Add Category</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- <li class="{{ Active::checkRoute(['locations.index', 'locations.create']) }}">
                <a class="sidebar-header" href="javascript:void(0)">
                    <i class="fas fa-location-arrow"></i>
                    <span>Manage Location</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>

                <ul class="sidebar-submenu">
                    <li class="{{ Active::checkRoute('locations.index') }}">
                        <a href="{{ route('locations.index') }}">
                            <i class="fa fa-circle"></i>
                            <span>Location List</span>
                        </a>
                    </li>

                    <li class="{{ Active::checkRoute('locations.create') }}">
                        <a href="{{ route('locations.create') }}">
                            <i class="fa fa-circle"></i>
                            <span>Add Location</span>
                        </a>
                    </li>
                </ul>
            </li> -->
            <!-- <li class="{{ Active::checkRoute(['skills.index', 'skills.create']) }}">
                <a class="sidebar-header" href="javascript:void(0)">
                    <i class="fas fa-stamp"></i>
                    <span>Manage Skill</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>

                <ul class="sidebar-submenu">
                    <li class="{{ Active::checkRoute('skills.index') }}">
                        <a href="{{ route('skills.index') }}">
                            <i class="fa fa-circle"></i>
                            <span>Skill List</span>
                        </a>
                    </li>

                    <li class="{{ Active::checkRoute('skills.create') }}">
                        <a href="{{ route('skills.create') }}">
                            <i class="fa fa-circle"></i>
                            <span>Add Skill</span>
                        </a>
                    </li>
                </ul>
            </li> -->

            <li class="{{ Active::checkRoute(['housekeepingradios.index', 'housekeepingradios.create']) }}">
                <a class="sidebar-header" href="javascript:void(0)">
                    <i class="fas fa-broom"></i>
                    <span>HouseKeeping Radio</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>

                <ul class="sidebar-submenu">
                    <li class="{{ Active::checkRoute('housekeepingradios.index') }}">
                        <a href="{{ route('housekeepingradios.index') }}">
                            <i class="fa fa-circle"></i>
                            <span>Radio List</span>
                        </a>
                    </li>

                    <li class="{{ Active::checkRoute('housekeepingradios.create') }}">
                        <a href="{{ route('housekeepingradios.create') }}">
                            <i class="fa fa-circle"></i>
                            <span>Add Radio</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- <li class="{{ Active::checkRoute(['housekeepings.index', 'housekeepings.create']) }}">
                <a class="sidebar-header" href="javascript:void(0)">
                    <i class="fas fa-broom"></i>
                    <span>HouseKeeping</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>

                <ul class="sidebar-submenu">
                    <li class="{{ Active::checkRoute('housekeepings.index') }}">
                        <a href="{{ route('housekeepings.index') }}">
                            <i class="fa fa-circle"></i>
                            <span>HouseKeeping List</span>
                        </a>
                    </li>

                    <li class="{{ Active::checkRoute('housekeepings.create') }}">
                        <a href="{{ route('housekeepings.create') }}">
                            <i class="fa fa-circle"></i>
                            <span>Add HouseKeeping</span>
                        </a>
                    </li>
                </ul>
            </li>
           <li class="{{ Active::checkRoute(['housekeepings.index', 'housekeepings.create']) }}">
                <a class="sidebar-header" href="javascript:void(0)">
                    <i class="fas fa-broom"></i>
                    <span>HouseKeeping</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>

                <ul class="sidebar-submenu">
                    <li class="{{ Active::checkRoute('housekeepings.index') }}">
                        <a href="{{ route('housekeepings.index') }}">
                            <i class="fa fa-circle"></i>
                            <span>HouseKeeping List</span>
                        </a>
                    </li>

                    <li class="{{ Active::checkRoute('housekeepings.create') }}">
                        <a href="{{ route('housekeepings.create') }}">
                            <i class="fa fa-circle"></i>
                            <span>Add HouseKeeping</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ Active::checkRoute(['persons.index']) }}">
                <a class="sidebar-header {{ Active::checkRoute(['persons.index']) }}" href="{{ route('persons.index') }}">
                    <i class="fa-solid fa-person-arrow-up-from-line"></i>
                    <span>Manage Person</span>
                </a>
            </li> -->

            <li class="{{ Active::checkRoute(['settings.index']) }}">
                <a class="sidebar-header {{ Active::checkRoute(['settings.index']) }}"
                    href="{{ route('settings.index') }}">
                    <i data-feather="settings"></i>
                    <span>Setting</span>
                </a>
            </li>

            <li>
                <a class="sidebar-header" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i data-feather="log-out"></i>
                    <span>
                        Logout
                    </span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
<!-- Page Sidebar Ends-->