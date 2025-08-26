<li class="nk-menu-item">
    <a href="{{ route('lab_technician.dashboard') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
        <span class="nk-menu-text">Dashboard</span>
    </a>
</li>

<li class="nk-menu-heading">
    <h6 class="overline-title">Laboratory Operations</h6>
</li>

<li class="nk-menu-item">
    <a href="{{ route('lab_technician.tests.pending') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-list-check"></em></span>
        <span class="nk-menu-text">Pending Tests</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('lab_technician.tests.completed') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-check-circle"></em></span>
        <span class="nk-menu-text">Completed Tests</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('lab_technician.results.upload') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-upload-cloud"></em></span>
        <span class="nk-menu-text">Upload Results</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('lab_technician.patients') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-user"></em></span>
        <span class="nk-menu-text">Patient Test History</span>
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