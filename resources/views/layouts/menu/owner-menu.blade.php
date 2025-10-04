{{-- Owner Menu --}}
<li class="nk-menu-item">
    <a href="{{ route('owner.dashboard') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
        <span class="nk-menu-text">Dashboard</span>
    </a>
</li>

<li class="nk-menu-heading">
    <h6 class="overline-title">System Administration</h6>
</li>

<li class="nk-menu-item">
    <a href="{{ route('owner.employees.manage') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-users-fill"></em></span>
        <span class="nk-menu-text">User Management</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('owner.hospitals.manage') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-building"></em></span>
        <span class="nk-menu-text">Hospital & Branches</span>
    </a>
</li>

<li class="nk-menu-item has-sub">
    <a href="#" class="nk-menu-link nk-menu-toggle">
        <span class="nk-menu-icon"><em class="icon ni ni-calendar"></em></span>
        <span class="nk-menu-text">Asset Management</span>
    </a>
    <ul class="nk-menu-sub">
        <li class="nk-menu-item"><a href="{{ route('assets.asset.create') }}" class="nk-menu-link"><span class="nk-menu-text">Add Asset</span></a></li>
        <li class="nk-menu-item"><a href="{{ route('assets.asset.index') }}" class="nk-menu-link"><span class="nk-menu-text">Assets</span></a></li>
        <li class="nk-menu-item"><a href="{{ route('assets.categories.index') }}" class="nk-menu-link"><span class="nk-menu-text">Categories</span></a></li>
        <li class="nk-menu-item"><a href="{{ route('assets.asset.index') }}" class="nk-menu-link"><span class="nk-menu-text">Maintainances</span></a></li>
    </ul>
</li>

<li class="nk-menu-item">
    <a href="{{ route('owner.reports.dashboard') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-trend-up"></em></span>
        <span class="nk-menu-text">System Reports</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('owner.settings') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-setting-alt"></em></span>
        <span class="nk-menu-text">System Settings</span>
    </a>
</li>

{{-- Logout Link with a form for security --}}
<li class="nk-menu-item">
    <a href="{{ route('logout') }}" class="nk-menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <span class="nk-menu-icon"><em class="icon ni ni-signout"></em></span>
        <span class="nk-menu-text">Logout</span>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</li>