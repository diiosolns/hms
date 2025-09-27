@extends('layouts.app')

@section('content')
    {{-- Place the HTML code here --}}
    <div class="nk-content">
                    <div class="container">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-between flex-wrap gap g-2">
                                        <div class="nk-block-head-content">
                                            <h2 class="nk-block-title">Pharmacy Stock</h2>
                                                <nav>
                                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                                        @if(Auth::user()->role === 'receptionist')
                                                        <li class="breadcrumb-item"><a href="{{ route('receptionist.dashboard') }}">Dashboard</a></li>
                                                        @elseif(Auth::user()->role === 'nurse')
                                                        <li class="breadcrumb-item"><a href="{{ route('nurse.dashboard') }}">Dashboard</a></li>
                                                        @elseif(Auth::user()->role === 'doctor')
                                                        <li class="breadcrumb-item"><a href="{{ route('doctor.dashboard') }}">Dashboard</a></li>
                                                        @elseif(Auth::user()->role === 'pharmacist')
                                                        <li class="breadcrumb-item"><a href="{{ route('pharmacist.dashboard') }}">Dashboard</a></li>
                                                        @elseif(Auth::user()->role === 'lab_technician')
                                                        <li class="breadcrumb-item"><a href="{{ route('lab_technician.dashboard') }}">Dashboard</a></li>
                                                        @elseif(Auth::user()->role === 'admin')
                                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                                        @elseif(Auth::user()->role === 'owner')
                                                        <li class="breadcrumb-item"><a href="{{ route('owner.dashboard') }}">Dashboard</a></li>
                                                        @endif

                                                        @if(in_array(Auth::user()->role, ['admin', 'pharmacist']))
                                                        <li class="breadcrumb-item"><a href="{{ route('pharmacy.create') }}">Add new record</a></li>
                                                        @endif
                                                        <li class="breadcrumb-item active" aria-current="page">Manage Stock Levels</li>
                                                    </ol>
                                                </nav>
                                        </div>
                                        <div class="nk-block-head-content">
                                            <ul class="d-flex">
                                                @if(Auth::user()->role === 'pharmacist')
                                                <li>
                                                    <a href="{{ route('pharmacist.stock.create') }}" class="btn btn-md d-md-none btn-primary" >
                                                        <em class="icon ni ni-plus"></em>
                                                        <span>Add</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('pharmacist.stock.create') }}" class="btn btn-primary d-none d-md-inline-flex" >
                                                        <em class="icon ni ni-plus"></em>
                                                        <span>Add Stock</span>
                                                    </a>
                                                </li>

                                                @elseif(Auth::user()->role === 'receptionist')

                                                @endif
                                            </ul>
                                        </div>
                                    </div><!-- .nk-block-head-between -->
                                </div><!-- .nk-block-head -->












                                <div class="nk-block">
                                    <div class="card">
                                        <table class="datatable-init table" data-nk-container="table-responsive">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="tb-col">Pharmacy Item</th>
                                                    <th class="tb-col">Category</th>
                                                    <th class="tb-col">Brand</th>
                                                    <th class="tb-col tb-col-xl">Form</th>
                                                    <th class="tb-col tb-col-md">Unit</th>
                                                    <th class="tb-col">Price (TZS)</th>
                                                    <th class="tb-col">Stock Type</th>
                                                    <th class="tb-col">Quantity</th>
                                                    <th class="tb-col">Balance</th>
                                                    <th class="tb-col">Batch</th>
                                                    <th class="tb-col">Expiry</th>
                                                    <th class="tb-col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($stock as $item)
                                                <tr>
                                                    <td class="tb-col">{{ $item->pharmacyItem->name ?? 'N/A' }}</td>
                                                    <td class="tb-col">{{ $item->pharmacyItem->category ?? 'N/A' }}</td>
                                                    <td class="tb-col">{{ $item->pharmacyItem->brand_name ?? 'N/A' }}</td>
                                                    <td class="tb-col tb-col-xl">{{ $item->pharmacyItem->form ?? 'N/A' }}</td>
                                                    <td class="tb-col tb-col-md">{{ $item->pharmacyItem->unit ?? 'N/A' }}</td>
                                                    <td class="tb-col">{{ $item->pharmacyItem->price ?? 0 }}</td>
                                                    <td class="tb-col">{{ ucfirst($item->type) }}</td>
                                                    <td class="tb-col">{{ $item->quantity }}</td>
                                                    <td class="tb-col">{{ $item->balance }}</td>
                                                    <td class="tb-col">{{ $item->batch_no ?? 'N/A' }}</td>
                                                    <td class="tb-col">{{ $item->expiry_date ? \Carbon\Carbon::parse($item->expiry_date)->format('M d, Y') : 'N/A' }}</td>
                                                    <td class="tb-col tb-col-end">
                                                        <div class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                                <em class="icon ni ni-more-v"></em>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                                <div class="dropdown-content py-1">
                                                                    <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                                        @if(in_array(Auth::user()->role, ['admin', 'pharmacist']))
                                                                        <li>
                                                                            <a href="{{ route('pharmacist.stock.edit', $item->id) }}">
                                                                                <em class="icon ni ni-edit"></em><span>Edit</span>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <form action="{{ route('pharmacist.stock.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="dropdown-item">
                                                                                    <em class="icon ni ni-trash"></em><span>Delete</span>
                                                                                </button>
                                                                            </form>
                                                                        </li>
                                                                        @else
                                                                        <li>
                                                                            <a href=""><span>Admin only</span></a>
                                                                        </li>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div><!-- dropdown -->
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="12" class="text-center text-muted">No stock records found.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        {{-- Pagination --}}
                                        {{ $stock->links() }}

                                    </div><!-- .card -->
                                </div><!-- .nk-block -->

                            </div>
                        </div>
                    </div>
                </div>

@endsection