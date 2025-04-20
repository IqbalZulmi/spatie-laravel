<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-heading">MAIN MENU</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('role.index') ? '' : ' collapsed' }}" href="{{ route('role.index') }}">
                <i class="bi bi-grid"></i>
                <span>Roles</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('permission.index') ? '' : ' collapsed' }}" href="{{ route('permission.index') }}">
                <i class="bi bi-people"></i>
                <span>Permission</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('user.assign.index') ? '' : ' collapsed' }}" href="{{ route('user.assign.index') }}">
                <i class="bi bi-person-gear"></i>
                <span>User Assign</span>
            </a>
        </li>
    </ul>
</aside><!-- End Sidebar-->
