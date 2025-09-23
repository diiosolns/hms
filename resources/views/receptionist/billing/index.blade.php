@extends('layouts.app')

@section('content')
                <div class="nk-content">
                    <div class="container">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-between flex-wrap gap g-2">
                                        <div class="nk-block-head-content">
                                            <h2 class="nk-block-title">Pendng Invoices</h2>
                                                <nav>
                                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                                        <li class="breadcrumb-item"><a href="{{ route('receptionist.dashboard') }}">Dashboard</a></li>
                                                        <li class="breadcrumb-item active" aria-current="page">Manage Invoices</li>
                                                    </ol>
                                                </nav>
                                        </div>
                                        <div class="nk-block-head-content">
                                            <ul class="d-flex">
                                                <!-- ADD ANY BUTTON HERE -->
                                            </ul>
                                        </div>
                                    </div><!-- .nk-block-head-between -->
                                </div><!-- .nk-block-head -->

                                <div class="nk-block">
                                    <div class="card">
                                        <table class="datatable-init table" data-nk-container="table-responsive">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="tb-col">
                                                        <span class="overline-title">Invoice No.</span>
                                                    </th>
                                                    <th class="tb-col">
                                                        <span class="overline-title">Amount (TZS)</span>
                                                    </th>
                                                    <th class="tb-col">
                                                        <span class="overline-title">Date</span>
                                                    </th>
                                                    <th class="tb-col">
                                                        <span class="overline-title">Last Update</span>
                                                    </th>
                                                    <th class="tb-col tb-col-md">
                                                        <span class="overline-title">Patient</span>
                                                    </th>
                                                    <th class="tb-col ">
                                                        <span class="overline-title">Registered by</span>
                                                    </th>
                                                    <th class="tb-col">
                                                        <span class="overline-title">Status</span>
                                                    </th>
                                                    <th class="tb-col tb-col-end" data-sortable="false">
                                                        <span class="overline-title">Action</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($pendingInvoices as $inv)
                                                <tr>
                                                    <td class="tb-col">
                                                        <div class="media-group">
                                                            <div class="media media-md media-middle media-circle text-bg-primary-soft">
                                                                <span class="smaller">
                                                                    {{ strtoupper(substr($inv->invoice_number, 0, 2) ) }}
                                                                </span>
                                                            </div>
                                                            <div class="media-text">
                                                                <a href="{{ route('invoices.show', $inv->id) }}" class="title">
                                                                    {{ $inv->invoice_number }}
                                                                </a>
                                                                <span class="small text">{{ $inv->status }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="tb-col">{{ number_format($inv->total_amount, 0) }}</td>
                                                    <td class="tb-col">{{ $inv->invoice_date ? \Carbon\Carbon::parse($inv->invoice_date)->format('M d, Y') : 'N/A' }}</td>
                                                    <td class="tb-col">
                                                        <span class="small">{{ $inv->updated_at ? $inv->updated_at->format('M d, h:i A') : 'N/A' }}</span>
                                                    </td>
                                                    <td class="tb-col tb-col-md">{{ $inv->patient->first_name . ' ' . $inv->patient->last_name }}</td>
                                                    <td class="tb-col ">{{ $inv->user->first_name . ' ' . $inv->user->last_name }}</td>
                                                    <td class="tb-col">
                                                        @if ($inv->status === 'Active')
                                                            <span class="badge text-bg-success-soft">{{ $inv->status }}</span>
                                                        @else
                                                            <span class="badge text-bg-danger-soft">{{ $inv->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="tb-col tb-col-end">
                                                        <a href="{{ route('invoices.show', $inv->id) }}" class="btn btn-sm btn-outline-primary">
                                                            View
                                                        </a>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="8" class="text-center text-bg-success-soft">No pending invoices found.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div><!-- .card -->
                                </div><!-- .nk-block -->
                            </div>
                        </div>
                    </div>
                </div>
@endsection