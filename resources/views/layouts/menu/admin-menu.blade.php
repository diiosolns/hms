<li class="nk-menu-item">
    <a href="{{ route('admin.dashboard') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
        <span class="nk-menu-text">Dashboard</span>
    </a>
</li>

<li class="nk-menu-heading">
    <h6 class="overline-title">Management</h6>
</li>

<li class="nk-menu-item has-sub">
    <a href="#" class="nk-menu-link nk-menu-toggle">
        <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
        <span class="nk-menu-text">User Management</span>
    </a>
    <ul class="nk-menu-sub">
        <li class="nk-menu-item"><a href="{{ route('admin.employees.manage') }}" class="nk-menu-link"><span class="nk-menu-text">All Users</span></a></li>
        <li class="nk-menu-item"><a href="{{ route('admin.employees.create') }}" class="nk-menu-link"><span class="nk-menu-text">Add New User</span></a></li>
    </ul>
</li>

<li class="nk-menu-item has-sub">
    <a href="#" class="nk-menu-link nk-menu-toggle">
        <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>
        <span class="nk-menu-text">Patient Management</span>
    </a>
    <ul class="nk-menu-sub">
        <li class="nk-menu-item"><a href="{{ route('admin.patients.index') }}" class="nk-menu-link"><span class="nk-menu-text">Patient List</span></a></li>
        <li class="nk-menu-item"><a href="{{ route('admin.patients.create') }}" class="nk-menu-link"><span class="nk-menu-text">Add New Patient</span></a></li>
    </ul>
</li>

<li class="nk-menu-item has-sub">
    <a href="#" class="nk-menu-link nk-menu-toggle">
        <span class="nk-menu-icon"><em class="icon ni ni-calendar"></em></span>
        <span class="nk-menu-text">Appointments</span>
    </a>
    <ul class="nk-menu-sub">
        <li class="nk-menu-item"><a href="{{ route('admin.appointments.index') }}" class="nk-menu-link"><span class="nk-menu-text">All Appointments</span></a></li>
        <li class="nk-menu-item"><a href="{{ route('admin.appointments.create') }}" class="nk-menu-link"><span class="nk-menu-text">Schedule Appointment</span></a></li>
    </ul>
</li>

<li class="nk-menu-item">
    <a href="{{ route('admin.billing.index') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-coins"></em></span>
        <span class="nk-menu-text">Billing</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('admin.pharmacy.index') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-capsule-fill"></em></span>
        <span class="nk-menu-text">Pharmacy</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('admin.lab.index') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-filter"></em></span>
        <span class="nk-menu-text">Laboratory</span>
    </a>
</li>


<li class="nk-menu-item">
    <a href="{{ route('admin.services.index') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-account-setting"></em></span>
        <span class="nk-menu-text">Services</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('admin.reports.index') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-file-docs"></em></span>
        <span class="nk-menu-text">Reports</span>
    </a>
</li>


<li class="nk-menu-item has-sub">
    <a href="#" class="nk-menu-link nk-menu-toggle">
        <span class="nk-menu-icon"><em class="icon ni ni-calendar"></em></span>
        <span class="nk-menu-text">Asset Management</span>
    </a>
    <ul class="nk-menu-sub">
        <li class="nk-menu-item"><a href="{{ route('admin.appointments.index') }}" class="nk-menu-link"><span class="nk-menu-text">Add Asset</span></a></li>
        <li class="nk-menu-item"><a href="{{ route('admin.appointments.create') }}" class="nk-menu-link"><span class="nk-menu-text">Available Assets</span></a></li>
    </ul>
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