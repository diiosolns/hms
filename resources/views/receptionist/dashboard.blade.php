
<style>
        .dashboard-card {
            text-align: center; /* Center all content */
        }
        .dashboard-card .card-icon {
            font-size: 3rem; /* Make icons very large */
            display: block; /* Make the icon a block element to center it */
            margin: 0 auto 1rem; /* Center the icon and add spacing below */
        }
        .card-link {
            text-decoration: none; /* Removes underline from the link */
            color: inherit;       /* Inherits text color */
        }
        .card-link:hover {
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15); /* Adds a subtle shadow on hover */
            transform: translateY(-2px); /* Lifts the card slightly on hover */
            transition: all 0.3s ease-in-out; /* Smooth transition */
        }
</style>


@extends('layouts.app')

@section('content')
    
    <div class="nk-content">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="row g-gs">
                        <div class="col-xxl-12">
                            <div class="row g-gs">
                                {{-- Card 1: Register New Patient --}}
                                <div class="col-md-4">
                                    {{-- Use a link tag to make the entire card clickable --}}
                                    <a href="{{ route('patients.index') }}" class="card h-100 card-link dashboard-card">
                                        <div class="card-body">
                                            <div class="card-icon text-primary"><em class="icon ni ni-user-add"></em></div>
                                            <h5 class="title mb-3">Patient Registration</h5>
                                            <div class="d-flex align-items-center justify-content-center smaller flex-wrap">
                                                <span class="text-light">Create a new patient record.</span>
                                            </div>
                                        </div><!-- .card-body -->
                                    </a><!-- .card -->
                                </div><!-- .col -->
                                
                                {{-- Card 2: Manage Appointments --}}
                                <div class="col-md-4">
                                    {{-- Use a link tag to make the entire card clickable --}}
                                    <a href="{{ route('appointments.index') }}" class="card h-100 card-link dashboard-card">
                                        <div class="card-body">
                                            <div class="card-icon text-primary"><em class="icon ni ni-calendar"></em></div>
                                            <h5 class="title mb-3">Manage Appointments</h5>
                                            <div class="d-flex align-items-center justify-content-center smaller flex-wrap">
                                                <span class="text-light">View, create, and modify appointments.</span>
                                            </div>
                                        </div><!-- .card-body -->
                                    </a><!-- .card -->
                                </div><!-- .col -->

                                {{-- Card 3: Manage Billing --}}
                                <div class="col-md-4">
                                    {{-- Use a link tag to make the entire card clickable --}}
                                    <a href="{{ route('billing.create') }}" class="card h-100 card-link dashboard-card">
                                        <div class="card-body">
                                            <div class="card-icon text-primary"><em class="icon ni ni-wallet"></em></div>
                                            <h5 class="title mb-3">Manage Billing</h5>
                                            <div class="d-flex align-items-center justify-content-center smaller flex-wrap">
                                                <span class="text-light">Handle patient billing and payments.</span>
                                            </div>
                                        </div><!-- .card-body -->
                                    </a><!-- .card -->
                                </div><!-- .col -->
                                
                            </div><!-- .row -->
                        </div><!-- .col -->
                    </div><!-- .row -->




                    <div class="row g-gs mt-4">
                        <div class="col-xxl-6">
                                        <div class="card h-100">
                                            <div class="card-body flex-grow-0 py-2">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h4 class="title">Pending Partients</h4>
                                                    </div>
                                                    <div class="card-tools">
                                                        <div class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                                <em class="icon ni ni-more-v"></em>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                                <li>
                                                                    <div class="dropdown-header pt-2 pb-0">
                                                                        <h6 class="mb-0">Options</h6>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <hr class="dropdown-divider">
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="dropdown-item">Low to high</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="dropdown-item">High to low</a>
                                                                </li>
                                                            </ul>
                                                        </div><!-- dropdown -->
                                                    </div>
                                                </div><!-- .card-title-group -->
                                            </div><!-- .card-body -->
                                            <div class="table-responsive">
                                                <table class="table table-middle mb-0">
                                                    <thead class="table-light table-head-sm">
                                                        <tr>
                                                            <th class="tb-col">
                                                                <span class="overline-title">products</span>
                                                            </th>
                                                            <th class="tb-col tb-col-end tb-col-sm">
                                                                <span class="overline-title">price</span>
                                                            </th>
                                                            <th class="tb-col tb-col-end tb-col-sm">
                                                                <span class="overline-title">orders</span>
                                                            </th>
                                                            <th class="tb-col tb-col-end tb-col-sm">
                                                                <span class="overline-title">stock</span>
                                                            </th>
                                                            <th class="tb-col tb-col-end">
                                                                <span class="overline-title">amount</span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="tb-col">
                                                                <div class="media-group">
                                                                    <div class="media media-md flex-shrink-0 media-middle media-circle">
                                                                        <img src="./images/product/a.jpg" alt="">
                                                                    </div>
                                                                    <div class="media-text">
                                                                        <span class="title">Nike v22 Running</span>
                                                                        <span class="text smaller">28 Jul 2022</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="tb-col tb-col-end tb-col-sm">
                                                                <span class="small">$130.20</span>
                                                            </td>
                                                            <td class="tb-col tb-col-end tb-col-sm">
                                                                <span class="small">38</span>
                                                            </td>
                                                            <td class="tb-col tb-col-end tb-col-sm">
                                                                <span class="small">436</span>
                                                            </td>
                                                            <td class="tb-col tb-col-end">
                                                                <span class="small">$14,945</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tb-col">
                                                                <div class="media-group">
                                                                    <div class="media media-md flex-shrink-0 media-middle media-circle">
                                                                        <img src="./images/product/b.jpg" alt="">
                                                                    </div>
                                                                    <div class="media-text">
                                                                        <span class="title">Business Kit (Mug)</span>
                                                                        <span class="text smaller">16 Oct 2022</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="tb-col tb-col-end tb-col-sm">
                                                                <span class="small">$18.35</span>
                                                            </td>
                                                            <td class="tb-col tb-col-end tb-col-sm">
                                                                <span class="small">12</span>
                                                            </td>
                                                            <td class="tb-col tb-col-end tb-col-sm">
                                                                <span class="badge text-bg-danger-soft">Out of Stock</span>
                                                            </td>
                                                            <td class="tb-col tb-col-end">
                                                                <span class="small">$7,458</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tb-col">
                                                                <div class="media-group">
                                                                    <div class="media media-md flex-shrink-0 media-middle media-circle">
                                                                        <img src="./images/product/c.jpg" alt="">
                                                                    </div>
                                                                    <div class="media-text">
                                                                        <span class="title">Borosil Paper Cup</span>
                                                                        <span class="text smaller">21 Feb 2022</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="tb-col tb-col-end tb-col-sm">
                                                                <span class="small">$328.00</span>
                                                            </td>
                                                            <td class="tb-col tb-col-end tb-col-sm">
                                                                <span class="small">120</span>
                                                            </td>
                                                            <td class="tb-col tb-col-end tb-col-sm">
                                                                <span class="small">867</span>
                                                            </td>
                                                            <td class="tb-col tb-col-end">
                                                                <span class="small">$7,806</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tb-col">
                                                                <div class="media-group">
                                                                    <div class="media media-md flex-shrink-0 media-middle media-circle">
                                                                        <img src="./images/product/d.jpg" alt="">
                                                                    </div>
                                                                    <div class="media-text">
                                                                        <span class="title">Mountain Trip Kit</span>
                                                                        <span class="text smaller">14 Jun 2022</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="tb-col tb-col-end tb-col-sm">
                                                                <span class="small">$130.20</span>
                                                            </td>
                                                            <td class="tb-col tb-col-end tb-col-sm">
                                                                <span class="small">184</span>
                                                            </td>
                                                            <td class="tb-col tb-col-end tb-col-sm">
                                                                <span class="small">226</span>
                                                            </td>
                                                            <td class="tb-col tb-col-end">
                                                                <span class="small">$17,945</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tb-col">
                                                                <div class="media-group">
                                                                    <div class="media media-md flex-shrink-0 media-middle media-circle">
                                                                        <img src="./images/product/e.jpg" alt="">
                                                                    </div>
                                                                    <div class="media-text">
                                                                        <span class="title">One Seater Sofa</span>
                                                                        <span class="text smaller">28 Jul 2022</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="tb-col tb-col-end tb-col-sm">
                                                                <span class="small">$130.20</span>
                                                            </td>
                                                            <td class="tb-col tb-col-end tb-col-sm">
                                                                <span class="small">50</span>
                                                            </td>
                                                            <td class="tb-col tb-col-end tb-col-sm">
                                                                <span class="badge text-bg-warning-soft">Low Stock</span>
                                                            </td>
                                                            <td class="tb-col tb-col-end">
                                                                <span class="small">$14,945</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div><!-- .card -->
                                    </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
@endsection
