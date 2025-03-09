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
                class="dropdown {{ Request::is(['userManagement', 'activity/log', 'activity/login/logout', 'user_role*']) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>Admin</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('userManagement') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('userManagement') }}">All
                            User</a></li>
                    <li class="{{ Request::is('user_role*') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('user_role.index') }}">Role Type</a></li>
                    <li class="{{ Request::is('activity/log') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('activity/log') }}">Activity Log</a></li>
                    <li class="{{ Request::is('activity/login/logout') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('activity/login/logout') }}">Activity User</a></li>
                </ul>
            </li>
            {{-- Setting Layout Company Profile --}}
            <li class="menu-header">Set Company Profile</li>
            <li
                class="dropdown {{ Request::is(['clients*', 'service_area*', 'service*', 'workforece_skill*', 'gallery*', 'comentars', 'legal*']) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>Management CP</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('clients*') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('clients.index') }}">Clients</a></li>
                    <li class="{{ Request::is('service*') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('service.index') }}">Pelayanan</a></li>
                    <li class="{{ Request::is('service_area*') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('service_area.index') }}">Wilayah Pelayanan</a></li>
                    <li class="{{ Request::is('service_strategy*') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('service_strategy.index') }}">Pelayanan Strategi</a></li>
                    <li class="{{ Request::is('workforece_skill*') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('workforece_skill.index') }}">Workforece Skill</a></li>
                    <li class="{{ Request::is('gallery*') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('gallery.index') }}">Gallery/Documentation</a></li>
                    <li class="{{ Request::is('legal*') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('legal.index') }}">Document
                            Legal</a></li>
                    <li class="{{ Request::is('comentars') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('comentars.index') }}">Komentar</a>
                    </li>
                </ul>
            </li>
        @elseif (Auth::user()->role_name == 'Super Admin')
            {{-- Setting Layout Company Profile --}}
            <li class="menu-header">Set Company Profile</li>
            <li
                class="dropdown {{ Request::is(['clients*', 'service_area*', 'service*', 'workforece_skill*', 'gallery*', 'comentars', 'legal*']) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>Management CP</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('clients*') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('clients.index') }}">Clients</a></li>
                    <li class="{{ Request::is('service*') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('service.index') }}">Pelayanan</a></li>
                    <li class="{{ Request::is('service_area*') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('service_area.index') }}">Wilayah Pelayanan</a></li>
                    <li class="{{ Request::is('service_strategy*') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('service_strategy.index') }}">Pelayanan Strategi</a></li>
                    <li class="{{ Request::is('workforece_skill*') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('workforece_skill.index') }}">Workforece Skill</a></li>
                    <li class="{{ Request::is('gallery*') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('gallery.index') }}">Gallery/Documentation</a></li>
                    <li class="{{ Request::is('legal*') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('legal.index') }}">Document
                            Legal</a></li>
                    <li class="{{ Request::is('comentars') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('comentars.index') }}">Komentar</a>
                    </li>
                </ul>
            </li>
        @endif
        <li class="menu-header">Master Data</li>
        <li class="dropdown {{ Request::is(['product*', 'group*', 'employe*', 'list_budget*']) ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i>
                <span>Master</span></a>
            <ul class="dropdown-menu">
                <li class="{{ Request::is('product*') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('product.index') }}">Produk</a></li>
                <li class="{{ Request::is('list_budget*') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('list_budget.index') }}">Jenis Pengeluaran</a></li>
                <li class="{{ Request::is('group*') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('group.index') }}">Group</a></li>
                <li class="{{ Request::is('employe*') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('employe.index') }}">Karyawan</a></li>
            </ul>
        </li>
        <li class="menu-header">Transaksi</li>
        <li class="dropdown {{ Request::is(['order*', 'invoice*', 'report_order*']) ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-file-invoice"></i>
                <span>Order & Invoice</span></a>
            <ul class="dropdown-menu">
                <li class="{{ Request::is('order*') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('order.index') }}">Order</a>
                </li>
                <li class="{{ Request::is('invoice*') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('invoice.index') }}">Invoice</a></li>
                <li class="{{ Request::is('report_order*') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('report_order.index') }}">Laporan</a></li>
            </ul>
        </li>
        <li class="dropdown {{ Request::is(['operational*']) ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-file-invoice"></i>
                <span>Operasional & Gaji</span></a>
            <ul class="dropdown-menu">
                <li class="{{ Request::is('operational*') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('operational.index') }}">Trans. Operasional</a>
                </li>
                <li class="#">
                    <a class="nav-link" href="javascript:void(0);" onclick="comingSoon()">Gaji (Coming
                        Soon)</a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
