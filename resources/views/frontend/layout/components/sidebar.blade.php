<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('home') }}">ABD</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('home') }}">AD</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="dropdown {{ Request::is(['home']) ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            <ul class="dropdown-menu">
                <li class="{{ Request::is('home') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('home') }}">Dashboard</a></li>
            </ul>
        </li>
        @if (Auth::user()->role_name == 'Admin')
            <li class="menu-header">Management Admin</li>
            <li
                class="dropdown {{ Request::is(['userManagement', 'activity/log', 'activity/login/logout']) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>Admin</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('userManagement') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('userManagement') }}">All
                            User</a></li>
                    <li class="{{ Request::is('activity/log') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('activity/log') }}">Activity Log</a></li>
                    <li class="{{ Request::is('activity/login/logout') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('activity/login/logout') }}">Activity User</a></li>
                </ul>
            </li>
        @endif
        <li class="menu-header">Master Data</li>
        <li class="dropdown">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i>
                <span>Master</span></a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="#">Product</a></li>
            </ul>
        </li>
        <li class="menu-header">Transaksi</li>
        <li><a class="nav-link" href="#"><i class="fas fa-pencil-ruler"></i> <span>Credits</span></a></li>
    </ul>
</aside>
