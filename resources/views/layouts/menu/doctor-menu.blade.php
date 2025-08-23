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
    <a href="{{ route('patients.my') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-folder"></em></span>
        <span class="nk-menu-text">My Patients</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('appointments.my') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-calendar"></em></span>
        <span class="nk-menu-text">My Appointments</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('lab.results') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-lab"></em></span>
        <span class="nk-menu-text">Lab Results</span>
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