<li class="nk-menu-item">
    <a href="{{ route('receptionist.dashboard') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
        <span class="nk-menu-text">Dashboard</span>
    </a>
</li>

<li class="nk-menu-heading">
    <h6 class="overline-title">Operations</h6>
</li>

<li class="nk-menu-item has-sub">
    <a href="#" class="nk-menu-link nk-menu-toggle">
        <span class="nk-menu-icon"><em class="icon ni ni-user-add"></em></span>
        <span class="nk-menu-text">Patient</span>
    </a>
    <ul class="nk-menu-sub">
        <li class="nk-menu-item"><a href="{{ route('patients.create') }}" class="nk-menu-link"><span class="nk-menu-text">Register New Patient</span></a></li>
        <li class="nk-menu-item"><a href="{{ route('patients.index') }}" class="nk-menu-link"><span class="nk-menu-text">Patient List</span></a></li>
    </ul>
</li>

<li class="nk-menu-item has-sub">
    <a href="#" class="nk-menu-link nk-menu-toggle">
        <span class="nk-menu-icon"><em class="icon ni ni-calendar-alt"></em></span>
        <span class="nk-menu-text">Appointments</span>
    </a>
    <ul class="nk-menu-sub">
        <li class="nk-menu-item"><a href="{{ route('appointments.create') }}" class="nk-menu-link"><span class="nk-menu-text">Schedule Appointment</span></a></li>
        <li class="nk-menu-item"><a href="{{ route('appointments.index') }}" class="nk-menu-link"><span class="nk-menu-text">All Appointments</span></a></li>
    </ul>
</li>

<li class="nk-menu-item">
    <a href="{{ route('billing.create') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-cc-alt2"></em></span>
        <span class="nk-menu-text">Billing</span>
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