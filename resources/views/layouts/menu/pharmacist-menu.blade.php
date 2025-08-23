<li class="nk-menu-item">
    <a href="{{ route('pharmacy.dashboard') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
        <span class="nk-menu-text">Dashboard</span>
    </a>
</li>

<li class="nk-menu-heading">
    <h6 class="overline-title">Pharmacy Management</h6>
</li>

<li class="nk-menu-item">
    <a href="{{ route('pharmacy.inventory') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-package-fill"></em></span>
        <span class="nk-menu-text">Inventory</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('pharmacy.prescriptions') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-file-text-fill"></em></span>
        <span class="nk-menu-text">Prescriptions</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('pharmacy.billing') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-coin"></em></span>
        <span class="nk-menu-text">Sales & Billing</span>
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