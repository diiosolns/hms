{{-- Nurse Menu --}}
<li class="nk-menu-item">
    <a href="{{ route('nurse.dashboard') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
        <span class="nk-menu-text">Dashboard</span>
    </a>
</li>

<li class="nk-menu-heading">
    <h6 class="overline-title">Patient Care</h6>
</li>

<li class="nk-menu-item">
    <a href="{{ route('nurse.patients') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>
        <span class="nk-menu-text">View Patients</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('nurse.vitals.log') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-heart"></em></span>
        <span class="nk-menu-text">Log Vitals</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('nurse.appointments') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-calendar"></em></span>
        <span class="nk-menu-text">Appointments</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('nurse.medication.log') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-pills"></em></span>
        <span class="nk-menu-text">Medication Log</span>
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
