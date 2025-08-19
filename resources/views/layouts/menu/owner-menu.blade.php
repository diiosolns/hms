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
    <a href="{{ route('owner.users.manage') }}" class="nk-menu-link">
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

<li class="nk-menu-item">
    <a href="{{ route('owner.reports.view') }}" class="nk-menu-link">
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