<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Multi-purpose admin dashboard template that especially build for programmers.">
    <title>HMS</title>
    <link rel="shortcut icon" href="{{ asset('images/app/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css?v1.1.1') }}">
</head>

<body class="nk-body" data-sidebar-collapse="lg" data-navbar-collapse="lg">
    <!-- Root -->
    <div class="nk-app-root">
        <!-- main  -->
        <div class="nk-main">


            <div class="nk-sidebar nk-sidebar-fixed is-theme" id="sidebar">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-sidebar-brand">
                        <a href="./html/index.html" class="logo-link">
                            <div class="logo-wrap">
                                <h1>HMS</h1>
                                <!-- <img class="logo-img logo-light" src="./images/logo.png" srcset="./images/logo2x.png 2x" alt="">
                                <img class="logo-img logo-dark" src="./images/logo-dark.png" srcset="./images/logo-dark2x.png 2x" alt="">
                                <img class="logo-img logo-icon" src="./images/logo-icon.png" srcset="./images/logo-icon2x.png 2x" alt=""> -->
                            </div>
                        </a>
                        <div class="nk-compact-toggle me-n1">
                            <button class="btn btn-md btn-icon text-light btn-no-hover compact-toggle">
                                <em class="icon off ni ni-chevrons-left"></em>
                                <em class="icon on ni ni-chevrons-right"></em>
                            </button>
                        </div>
                        <div class="nk-sidebar-toggle me-n1">
                            <button class="btn btn-md btn-icon text-light btn-no-hover sidebar-toggle">
                                <em class="icon ni ni-arrow-left"></em>
                            </button>
                        </div>
                    </div><!-- end nk-sidebar-brand -->
                </div><!-- end nk-sidebar-element -->

                <div class="nk-sidebar-element nk-sidebar-body">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <ul class="nk-menu">
                                
                                {{-- Admin Menu --}}
                                @if(Auth::user()->role === 'admin')
                                    @include('layouts.menu.admin-menu')
                                {{-- Doctor Menu --}}
                                @elseif(Auth::user()->role === 'nurse')
                                    @include('layouts.menu.nurse-menu')
                                @elseif(Auth::user()->role === 'doctor')
                                    @include('layouts.menu.doctor-menu')
                                {{-- Receptionist Menu --}}
                                @elseif(Auth::user()->role === 'receptionist')
                                    @include('layouts.menu.receptionist-menu')
                                {{-- Pharmacist Menu --}}
                                @elseif(Auth::user()->role === 'pharmacist')
                                    @include('layouts.menu.pharmacist-menu')
                                @elseif(Auth::user()->role === 'lab_technician')
                                    @include('layouts.menu.lab_technician-menu')
                                @elseif(Auth::user()->role === 'owner')
                                    @include('layouts.menu.owner-menu')
                                @endif

                            </ul><!-- .nk-menu -->
                        </div><!-- .nk-sidebar-menu -->
                    </div><!-- .nk-sidebar-content -->
                </div><!-- .nk-sidebar-element -->

            </div><!-- .nki-sidebar -->
            <!-- sidebar @e -->












            <!-- wrap -->
            <div class="nk-wrap">
                <!-- include Header  -->
                <div class="nk-header nk-header-fixed">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">
                            <div class="nk-header-logo ms-n1">
                                <div class="nk-sidebar-toggle">
                                    <button class="btn btn-sm btn-icon btn-zoom sidebar-toggle d-sm-none"><em class="icon ni ni-menu"></em></button>
                                    <button class="btn btn-md btn-icon btn-zoom sidebar-toggle d-none d-sm-inline-flex"><em class="icon ni ni-menu"></em></button>
                                </div>
                                <div class="nk-navbar-toggle me-2">
                                    <button class="btn btn-sm btn-icon btn-zoom navbar-toggle d-sm-none"><em class="icon ni ni-menu-right"></em></button>
                                    <button class="btn btn-md btn-icon btn-zoom navbar-toggle d-none d-sm-inline-flex"><em class="icon ni ni-menu-right"></em></button>
                                </div>
                                <a href="./html/index.html" class="logo-link">
                                    <div class="logo-wrap">
                                        <img class="logo-img logo-light" src="./images/logo.png" srcset="./images/logo2x.png 2x" alt="">
                                        <img class="logo-img logo-dark" src="./images/logo-dark.png" srcset="./images/logo-dark2x.png 2x" alt="">
                                        <img class="logo-img logo-icon" src="./images/logo-icon.png" srcset="./images/logo-icon2x.png 2x" alt="">
                                    </div>
                                </a>
                            </div>






                            <nav class="nk-header-menu nk-navbar">
                                <ul class="nk-nav">
                                    <li class="nk-nav-item has-sub">
                                        <a href="#" class="nk-nav-link nk-nav-toggle">
                                            <span class="nk-nav-text">Quick Links</span>
                                        </a>
                                        <ul class="nk-nav-sub nk-nav-sub-lg">
                                            @if(Auth::user()->role === 'receptionist')
                                            <li class="nk-nav-item">
                                                <a href="{{ route('receptionist.dashboard') }}" class="nk-nav-link bg-primary-soft-hover">
                                                    <div class="media-group flex-grow-1">
                                                        <div class="media media-md media-middle media-border text-bg-primary-soft-outline">
                                                            <em class="icon ni ni-dashboard-fill"></em>
                                                        </div>
                                                        <div class="media-text flex-grow-1">
                                                            <span class="title">Dashboard</span>
                                                            <span class="sub-text d-block">Explore System Insights</span>
                                                        </div>
                                                    </div><!-- .media-group -->
                                                </a>
                                            </li>
                                            <li class="nk-nav-item">
                                                <a href="{{ route('patients.index') }}" class="nk-nav-link bg-primary-soft-hover">
                                                    <div class="media-group flex-grow-1">
                                                        <div class="media media-md media-middle media-border text-bg-primary-soft-outline">
                                                            <em class="icon ni ni-user-add"></em>
                                                        </div>
                                                        <div class="media-text flex-grow-1">
                                                            <span class="title">Patients</span>
                                                            <span class="sub-text d-block">Manage Patient Details</span>
                                                        </div>
                                                    </div><!-- .media-group -->
                                                </a>
                                            </li>
                                            <li class="nk-nav-item">
                                                <a href="{{ route('appointments.index') }}" class="nk-nav-link bg-primary-soft-hover">
                                                    <div class="media-group flex-grow-1">
                                                        <div class="media media-md media-middle media-border text-bg-primary-soft-outline">
                                                            <em class="icon ni ni-calendar"></em>
                                                        </div>
                                                        <div class="media-text flex-grow-1">
                                                            <span class="title">Appointments</span>
                                                            <span class="sub-text d-block">Manage patient appointmets</span>
                                                        </div>
                                                    </div><!-- .media-group -->
                                                </a>
                                            </li>
                                            <li class="nk-nav-item">
                                                <a href="{{ route('receptionist.billing.index') }}" class="nk-nav-link bg-primary-soft-hover">
                                                    <div class="media-group flex-grow-1">
                                                        <div class="media media-md media-middle media-border text-bg-primary-soft-outline">
                                                            <em class="icon ni ni-wallet"></em>
                                                        </div>
                                                        <div class="media-text flex-grow-1">
                                                            <span class="title">Billing</span>
                                                            <span class="sub-text d-block">Manage Pending Invoices</span>
                                                        </div>
                                                    </div><!-- .media-group -->
                                                </a>
                                            </li>
                                            <li class="nk-nav-item">
                                                <a href="{{ route('receptionist.reports.index') }}" class="nk-nav-link bg-primary-soft-hover">
                                                    <div class="media-group flex-grow-1">
                                                        <div class="media media-md media-middle media-border text-bg-primary-soft-outline">
                                                            <em class="icon ni ni-reports"></em>
                                                        </div>
                                                        <div class="media-text flex-grow-1">
                                                            <span class="title">Reports</span>
                                                            <span class="sub-text d-block">View and Download Reports</span>
                                                        </div>
                                                    </div><!-- .media-group -->
                                                </a>
                                            </li>
                                            @elseif(Auth::user()->role === 'nurse')
                                            <li class="nk-nav-item">
                                                <a href="./html/index.html" class="nk-nav-link bg-primary-soft-hover">
                                                    <div class="media-group flex-grow-1">
                                                        <div class="media media-md media-middle media-border text-bg-primary-soft-outline">
                                                            <em class="icon ni ni-dashboard-fill"></em>
                                                        </div>
                                                        <div class="media-text flex-grow-1">
                                                            <span class="title">Default</span>
                                                            <span class="sub-text d-block">Website Analytics</span>
                                                        </div>
                                                    </div><!-- .media-group -->
                                                </a>
                                            </li>
                                            <li class="nk-nav-item">
                                                <a href="./html/index-ecommerce.html" class="nk-nav-link bg-secondary-soft-hover">
                                                    <div class="media-group flex-grow-1">
                                                        <div class="media media-md media-middle media-border text-bg-secondary-soft-outline">
                                                            <em class="icon ni ni-cart-fill"></em>
                                                        </div>
                                                        <div class="media-text flex-grow-1">
                                                            <span class="title">eCommerce</span>
                                                            <span class="sub-text d-block">Sales reports</span>
                                                        </div>
                                                    </div><!-- .media-group -->
                                                </a>
                                            </li>
                                            <li class="nk-nav-item">
                                                <a href="./html/index-project.html" class="nk-nav-link bg-success-soft-hover">
                                                    <div class="media-group flex-grow-1">
                                                        <div class="media media-md media-middle media-border text-bg-success-soft-outline">
                                                            <em class="icon ni ni-link-group"></em>
                                                        </div>
                                                        <div class="media-text flex-grow-1">
                                                            <span class="title">Project</span>
                                                            <span class="sub-text d-block">Tasts, graphs & charts</span>
                                                        </div>
                                                    </div><!-- .media-group -->
                                                </a>
                                            </li>
                                            <li class="nk-nav-item">
                                                <a href="./html/index-marketing.html" class="nk-nav-link bg-info-soft-hover">
                                                    <div class="media-group flex-grow-1">
                                                        <div class="media media-md media-middle media-border text-bg-info-soft-outline">
                                                            <em class="icon ni ni-growth-fill"></em>
                                                        </div>
                                                        <div class="media-text flex-grow-1">
                                                            <span class="title">Marketing</span>
                                                            <span class="sub-text d-block">Campaings & conversions</span>
                                                        </div>
                                                    </div><!-- .media-group -->
                                                </a>
                                            </li>
                                            <li class="nk-nav-item">
                                                <a href="./html/index-nft.html" class="nk-nav-link bg-danger-soft-hover">
                                                    <div class="media-group flex-grow-1">
                                                        <div class="media media-md media-middle media-border text-bg-danger-soft-outline">
                                                            <em class="icon ni ni-img-fill"></em>
                                                        </div>
                                                        <div class="media-text flex-grow-1">
                                                            <span class="title">NFT</span>
                                                            <span class="sub-text d-block">Sell &amp; Create your own NFTs</span>
                                                        </div>
                                                    </div><!-- .media-group -->
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </li>
                                    
                                    <li class="nk-nav-item has-sub">
                                        <a href="#" class="nk-nav-link nk-nav-toggle">
                                            <span class="nk-nav-text">Features</span>
                                        </a>
                                        <div class="nk-nav-sub">
                                            <div class="nk-nav-mega nk-nav-mega-lg">
                                                <div class="nk-nav-col">
                                                    <h6 class="nk-nav-heading">Reception</h6>
                                                    <ul class="link-list link-list-md link-list-hover-bg-primary">
                                                        <li>
                                                            <a href="{{ route('patients.index') }}">Patients</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('appointments.index') }}">Appointmets</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('receptionist.billing.index') }}">Billing</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('receptionist.reports.index') }}">Reports</a>
                                                        </li>
                                                    </ul>
                                                    <h6 class="nk-nav-heading">Nurse</h6>
                                                    <ul class="link-list link-list-md link-list-hover-bg-primary">
                                                        <li>
                                                            <a href="./html/components/alerts.html">Vitals</a>
                                                        </li>
                                                        <li>
                                                            <a href="./html/components/accordion.html">Appointments</a>
                                                        </li>
                                                        <li>
                                                            <a href="./html/components/accordion.html">Reports</a>
                                                        </li>
                                                    </ul>
                                                </div><!-- .nk-nav-col -->
                                                <div class="nk-nav-col">                                                    <h6 class="nk-nav-heading">Laboratory</h6>
                                                    <ul class="link-list link-list-md link-list-hover-bg-primary">
                                                        <li>
                                                            <a href="./html/utilities/background.html">Lab Test</a>
                                                        </li>
                                                        <li>
                                                            <a href="./html/utilities/borders.html">Test Results</a>
                                                        </li>
                                                        <li>
                                                            <a href="./html/utilities/colors.html">Appointments</a>
                                                        </li>
                                                        <li>
                                                            <a href="./html/utilities/misc.html">Reports</a>
                                                        </li>
                                                    </ul>
                                                    <h6 class="nk-nav-heading">Pharmacy</h6>
                                                    <ul class="link-list link-list-md link-list-hover-bg-primary">
                                                        <li>
                                                            <a href="./html/layout/breakpoints.html">Prescription</a>
                                                        </li>
                                                        <li>
                                                            <a href="./html/layout/containers.html">Drugs</a>
                                                        </li>
                                                        <li>
                                                            <a href="./html/layout/gutters.html">Dispense</a>
                                                        </li>
                                                        <li>
                                                            <a href="./html/layout/gutters.html">Reports</a>
                                                        </li>
                                                    </ul>
                                                </div><!-- .nk-nav-col -->
                                                <div class="nk-nav-col">
                                                    <h6 class="nk-nav-heading">Doctor</h6>
                                                    <ul class="link-list link-list-md link-list-hover-bg-primary">
                                                        <li>
                                                            <a href="./html/components/carousel.html">Patients</a>
                                                        </li>
                                                        <li>
                                                            <a href="./html/components/collapse.html">Appointments</a>
                                                        </li>
                                                        <li>
                                                            <a href="./html/components/collapse.html">Prescriprions</a>
                                                        </li>
                                                        <li>
                                                            <a href="./html/components/tooltips.html">Lab Tests</a>
                                                        </li>
                                                        <li>
                                                            <a href="./html/components/tooltips.html">Test Results</a>
                                                        </li>
                                                        <li>
                                                            <a href="./html/components/tooltips.html">Reports</a>
                                                        </li>
                                                    </ul>
                                                </div><!-- .nk-nav-col -->
                                                <div class="nk-nav-col nk-nav-media">
                                                    <img src="{{ asset('images/app/a.png') }}" alt="" class="rounded-3">
                                                </div><!-- .nk-nav-col -->
                                            </div><!-- .nk-nav-mega -->
                                        </div>
                                    </li>
                                </ul>
                            </nav>







                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav ms-2">
                                    <li class="dropdown">
                                        <button class="btn btn-icon btn-sm btn-zoom d-sm-none" data-bs-toggle="dropdown" data-bs-auto-close="outside"><em class="icon ni ni-search"></em></button>
                                        <button class="btn btn-icon btn-md btn-zoom d-none d-sm-inline-flex" data-bs-toggle="dropdown" data-bs-auto-close="outside"><em class="icon ni ni-search"></em></button>
                                        <div class="dropdown-menu dropdown-menu-lg">
                                            <div class="dropdown-content dropdown-content-x-lg py-1">
                                                <div class="search-inline">
                                                    <div class="form-control-wrap flex-grow-1">
                                                        <input placeholder="Type Query" type="text" class="form-control-plaintext">
                                                    </div>
                                                    <em class="icon icon-sm ni ni-search"></em>
                                                </div>
                                            </div>
                                            <div class="dropdown-divider m-0"></div>
                                            <div class="dropdown-content dropdown-content-x-lg py-3">
                                                <div class="dropdown-title pb-2">
                                                    <h5 class="title">Recent searches</h5>
                                                </div>
                                                <ul class="dropdown-list gap gy-2">
                                                    <li>
                                                        <div class="media-group">
                                                            <div class="media media-md media-middle media-circle text-bg-light"><em class="icon ni ni-clock"></em></div>
                                                            <div class="media-text">
                                                                <div class="lead-text">Styled Doughnut Chart</div>
                                                                <span class="sub-text">1 days ago</span>
                                                            </div>
                                                            <div class="media-action media-action-end">
                                                                <button class="btn btn-md btn-zoom btn-icon me-n1"><em class="icon ni ni-trash"></em></button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="media-group">
                                                            <div class="media media-md media-middle media-circle text-bg-light"><em class="icon ni ni-clock"></em></div>
                                                            <div class="media-text">
                                                                <div class="lead-text">Custom Select Input</div>
                                                                <span class="sub-text">07 Aug</span>
                                                            </div>
                                                            <div class="media-action media-action-end">
                                                                <button class="btn btn-md btn-zoom btn-icon me-n1"><em class="icon ni ni-trash"></em></button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="media-group">
                                                            <div class="media media-md media-middle media-circle text-bg-light"><img src="./images/avatar/a.jpg" alt=""></div>
                                                            <div class="media-text">
                                                                <div class="lead-text">Sharon Walker</div>
                                                                <span class="sub-text">Admin</span>
                                                            </div>
                                                            <div class="media-action media-action-end">
                                                                <button class="btn btn-md btn-zoom btn-icon me-n1"><em class="icon ni ni-trash"></em></button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <button class="btn btn-icon btn-sm btn-zoom d-sm-none" data-bs-toggle="offcanvas" data-bs-target="#notificationOffcanvas"><em class="icon ni ni-bell"></em></button>
                                        <button class="btn btn-icon btn-md btn-zoom d-none d-sm-inline-flex" data-bs-toggle="offcanvas" data-bs-target="#notificationOffcanvas"><em class="icon ni ni-bell"></em></button>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" data-bs-toggle="dropdown">
                                            <div class="d-sm-none">
                                                <div class="media media-md media-circle">
                                                    <img src="{{ asset('images/users/def.jpg') }}" alt="" class="img-thumbnail">
                                                </div>
                                            </div>
                                            <div class="d-none d-sm-block">
                                                <div class="media media-circle">
                                                    <img src="{{ asset('images/users/def.jpg') }}" alt="" class="img-thumbnail">
                                                </div>
                                            </div>
                                        </a>
                                       <div class="dropdown-menu dropdown-menu-md">
                                            <div class="dropdown-content dropdown-content-x-lg py-3 border-bottom border-light">
                                                <div class="media-group">
                                                    <div class="media media-xl media-middle media-circle"><img src="{{ asset('images/users/def.jpg') }}" alt="" class="img-thumbnail"></div>
                                                    <div class="media-text">
                                                        {{-- Display the authenticated user's name dynamically --}}
                                                        <div class="lead-text">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                                                        {{-- Display the authenticated user's role dynamically --}}
                                                        <span class="sub-text">{{ ucfirst(Auth::user()->role) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-content dropdown-content-x-lg py-3 border-bottom border-light">
                                                <ul class="link-list">
                                                     {{-- Common routes for all roles --}}
                                                    <li><a href="{{ route('profile', ['id' => Auth::user()->id]) }}"><em class="icon ni ni-user"></em> <span>My Profile</span></a></li>
                                                    <li><a href="{{ route('profile.settings', ['id' => Auth::user()->id]) }}"><em class="icon ni ni-setting-alt"></em> <span>Account Settings</span></a></li>
                                                </ul>
                                            </div>
                                            <div class="dropdown-content dropdown-content-x-lg py-3">
                                                <ul class="link-list">
                                                    <li>
                                                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                            <em class="icon ni ni-signout"></em> <span>Log Out</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        {{-- This form is required for the logout functionality --}}
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>




                                    </li>
                                </ul>
                            </div><!-- .nk-header-tools -->


                        </div><!-- .nk-header-wrap -->
                    </div><!-- .container-fliud -->
                </div>
                <!-- header -->















                <!-- content -->
                {{-- The content from the specific dashboard file will be inserted here --}}
                @yield('content')
                <!-- .nk-content -->










                <!-- include Footer -->
                <div class="nk-footer">
                    <div class="container-fluid">
                        <div class="nk-footer-wrap">
                            <div class="nk-footer-copyright"> &copy; 2025 HMS: Hospital Management System - <a href="https://nizybit.pw" target="_blank" class="text-reset">NyziBit</a>
                            </div>
                            <div class="nk-footer-links">
                                <ul class="nav nav-sm">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">About</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Support</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Blog</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div><!-- .nk-footer -->

            </div> <!-- .nk-wrap -->
        </div> <!-- .nk-main -->
    </div> <!-- .nk-app-root -->
</body>










<!-- JavaScript -->
<script src="{{ asset('assets/js/bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<div class="offcanvas offcanvas-end offcanvas-size-lg" id="notificationOffcanvas">
    <div class="offcanvas-header border-bottom border-light">
        <h5 class="offcanvas-title" id="offcanvasTopLabel">Recent Notification</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" data-simplebar>
        <ul class="nk-schedule">
            <li class="nk-schedule-item">
                <div class="nk-schedule-item-inner">
                    <div class="nk-schedule-symbol active"></div>
                    <div class="nk-schedule-content">
                        <span class="smaller">2:12 PM</span>
                        <div class="h6">Added 3 New Images</div>
                        <ul class="d-flex flex-wrap gap g-2 py-2">
                            <li>
                                <div class="media media-xxl">
                                    <img src="./images/product/a.jpg" alt="" class="img-thumbnail">
                                </div>
                            </li>
                            <li>
                                <div class="media media-xxl">
                                    <img src="./images/product/b.jpg" alt="" class="img-thumbnail">
                                </div>
                            </li>
                            <li>
                                <div class="media media-xxl">
                                    <img src="./images/product/c.jpg" alt="" class="img-thumbnail">
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            <li class="nk-schedule-item">
                <div class="nk-schedule-item-inner">
                    <div class="nk-schedule-symbol active"></div>
                    <div class="nk-schedule-content">
                        <span class="smaller">4:23 PM</span>
                        <div class="h6">Invitation for creative designs pattern</div>
                    </div>
                </div>
            </li>
            <li class="nk-schedule-item">
                <div class="nk-schedule-item-inner">
                    <div class="nk-schedule-symbol active"></div>
                    <div class="nk-schedule-content nk-schedule-content-no-border">
                        <span class="smaller">10:30 PM</span>
                        <div class="h6">Task report - uploaded weekly reports</div>
                        <div class="list-group-dotted mt-3">
                            <div class="list-group-wrap">
                                <div class="p-3">
                                    <div class="media-group">
                                        <div class="media rounded-0">
                                            <img src="./images/icon/file-type-pdf.svg" alt="">
                                        </div>
                                        <div class="media-text ms-1">
                                            <a href="#" class="title">Modern Designs Pattern</a>
                                            <span class="text smaller">1.6.mb</span>
                                        </div>
                                    </div><!-- .media-group -->
                                </div>
                                <div class="p-3">
                                    <div class="media-group">
                                        <div class="media rounded-0">
                                            <img src="./images/icon/file-type-doc.svg" alt="">
                                        </div>
                                        <div class="media-text ms-1">
                                            <a href="#" class="title">Cpanel Upload Guidelines</a>
                                            <span class="text smaller">18kb</span>
                                        </div>
                                    </div><!-- .media-group -->
                                </div>
                                <div class="p-3">
                                    <div class="media-group">
                                        <div class="media rounded-0">
                                            <img src="./images/icon/file-type-code.svg" alt="">
                                        </div>
                                        <div class="media-text ms-1">
                                            <a href="#" class="title">Weekly Finance Reports</a>
                                            <span class="text smaller">10mb</span>
                                        </div>
                                    </div><!-- .media-group -->
                                </div>
                            </div>
                        </div><!-- .list-group-dotted -->
                    </div>
                </div>
            </li>
            <li class="nk-schedule-item">
                <div class="nk-schedule-item-inner">
                    <div class="nk-schedule-symbol active"></div>
                    <div class="nk-schedule-content">
                        <span class="smaller">3:23 PM</span>
                        <div class="h6">Assigned you to new database design project</div>
                    </div>
                </div>
            </li>
            <li class="nk-schedule-item">
                <div class="nk-schedule-item-inner">
                    <div class="nk-schedule-symbol active"></div>
                    <div class="nk-schedule-content nk-schedule-content-no-border flex-grow-1">
                        <span class="smaller">5:05 PM</span>
                        <div class="h6">You have received a new order</div>
                        <div class="alert alert-info mt-2" role="alert">
                            <div class="d-flex">
                                <em class="icon icon-lg ni ni-file-code opacity-75"></em>
                                <div class="ms-2 d-flex flex-wrap flex-grow-1 justify-content-between">
                                    <div>
                                        <h6 class="alert-heading mb-0">Business Template - UI/UX design</h6>
                                        <span class="smaller">Shared information with your team to understand and contribute to your project.</span>
                                    </div>
                                    <div class="d-block mt-1">
                                        <a href="#" class="btn btn-md btn-info"><em class="icon ni ni-download"></em><span>Download</span></a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .alert -->
                    </div>
                </div>
            </li>
            <li class="nk-schedule-item">
                <div class="nk-schedule-item-inner">
                    <div class="nk-schedule-symbol active"></div>
                    <div class="nk-schedule-content">
                        <span class="smaller">2:45 PM</span>
                        <div class="h6">Project status updated successfully</div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- <script src="./assets/js/data-tables/data-tables.js"></script> -->
<script src="{{ asset('assets/js/data-tables/data-tables.js') }}"></script>
<script src="{{ asset('assets/js/charts/analytics-chart.js') }}"></script>



</html>