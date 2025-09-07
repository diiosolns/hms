<li class="nk-menu-item">
    <a href="{{ route('pharmacist.dashboard') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
        <span class="nk-menu-text">Dashboard</span>
    </a>
</li>

<li class="nk-menu-heading">
    <h6 class="overline-title">Pharmacy Management</h6>
</li>

{{-- Pharmacy Items --}}
<li class="nk-menu-item">
    <a href="{{ route('pharmacist.items.index') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-capsule"></em></span>
        <span class="nk-menu-text">Pharmacy Items</span>
    </a>
</li>

{{-- Stock Management --}}
<li class="nk-menu-item has-sub">
    <a href="#" class="nk-menu-link nk-menu-toggle">
        <span class="nk-menu-icon"><em class="icon ni ni-package-fill"></em></span>
        <span class="nk-menu-text">Stock Management</span>
    </a>
    <ul class="nk-menu-sub">
        <li class="nk-menu-item">
            <a href="{{ route('pharmacist.stock.index') }}" class="nk-menu-link">
                <span class="nk-menu-text">Stock Levels</span>
            </a>
        </li>
        <li class="nk-menu-item">
            <a href="{{ route('pharmacist.stock.create') }}" class="nk-menu-link">
                <span class="nk-menu-text">Add Stock</span>
            </a>
        </li>
        <li class="nk-menu-item">
            <a href="{{ route('pharmacist.stock.adjustments') }}" class="nk-menu-link">
                <span class="nk-menu-text">Adjust Stock</span>
            </a>
        </li>
    </ul>
</li>

{{-- Prescriptions --}}
<li class="nk-menu-item">
    <a href="{{ route('pharmacist.prescriptions') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-file-text-fill"></em></span>
        <span class="nk-menu-text">Prescriptions</span>
    </a>
</li>

{{-- Reports --}}
<li class="nk-menu-item has-sub">
    <a href="#" class="nk-menu-link nk-menu-toggle">
        <span class="nk-menu-icon"><em class="icon ni ni-reports"></em></span>
        <span class="nk-menu-text">Reports</span>
    </a>
    <ul class="nk-menu-sub">
        <li class="nk-menu-item">
            <a href="{{ route('pharmacist.reports.stock') }}" class="nk-menu-link">
                <span class="nk-menu-text">Stock Report</span>
            </a>
        </li>
        <li class="nk-menu-item">
            <a href="{{ route('pharmacist.reports.profit') }}" class="nk-menu-link">
                <span class="nk-menu-text">Profit & Loss</span>
            </a>
        </li>
        <li class="nk-menu-item">
            <a href="{{ route('pharmacist.reports.expiry') }}" class="nk-menu-link">
                <span class="nk-menu-text">Expiry Report</span>
            </a>
        </li>
    </ul>
</li>

{{-- Logout --}}
<li class="nk-menu-item">
    <a href="{{ route('logout') }}" class="nk-menu-link" 
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <span class="nk-menu-icon"><em class="icon ni ni-signout"></em></span>
        <span class="nk-menu-text">Logout</span>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</li>
