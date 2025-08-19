<li class="nk-menu-item">
    <a href="{{ route('lab.dashboard') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
        <span class="nk-menu-text">Dashboard</span>
    </a>
</li>

<li class="nk-menu-heading">
    <h6 class="overline-title">Laboratory Operations</h6>
</li>

<li class="nk-menu-item">
    <a href="{{ route('lab.tests.pending') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-list-check"></em></span>
        <span class="nk-menu-text">Pending Tests</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('lab.tests.completed') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-check-circle"></em></span>
        <span class="nk-menu-text">Completed Tests</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('lab.results.upload') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-upload-cloud"></em></span>
        <span class="nk-menu-text">Upload Results</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('lab.patients') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-user"></em></span>
        <span class="nk-menu-text">Patient Test History</span>
    </a>
</li>