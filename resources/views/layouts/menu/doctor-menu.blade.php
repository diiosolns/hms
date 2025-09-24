<li class="nk-menu-item">
    <a href="{{ route('doctor.dashboard') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
        <span class="nk-menu-text">Dashboard</span>
    </a>
</li>

<li class="nk-menu-heading">
    <h6 class="overline-title">My Services</h6>
</li>

<li class="nk-menu-item">
    <a href="{{ route('doctor.patients') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-folder"></em></span>
        <span class="nk-menu-text">My Patients</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('doctor.appointments') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-calendar"></em></span>
        <span class="nk-menu-text">My Appointments</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('patients.index') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
        <span class="nk-menu-text">Patients</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('doctor.reports') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-reports"></em></span>
        <span class="nk-menu-text">Reports</span>
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