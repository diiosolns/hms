@extends('layouts.app')

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    @if ($invoice)
                        <div class="nk-block-head">
                            <div class="nk-block-head-between flex-wrap gap g-2 align-items-start">
                                <div class="nk-block-head-content">
                                    <div class="d-flex flex-column flex-md-row align-items-md-center">
                                        <a href="{{ route('patients.show', $invoice->patient->id) }}">
                                            <div class="media media-huge media-middle media-circle text-bg-primary-soft">
                                                <span class="huge">{{ strtoupper(substr($invoice->invoice_number, 0, 3)) }}</span>
                                            </div>
                                        </a>
                                        <div class="mt-3 mt-md-0 ms-md-3">
                                            <h3 class="title mb-1">{{ $invoice->patient->first_name }} {{ $invoice->patient->last_name }}</h3>
                                            <span class="badge bg-primary">Invoice No.: {{ $invoice->invoice_number }}</span>
                                            <ul class="nk-list-option pt-1">
                                                @if ($invoice->patient->branch)
                                                    <li><em class="icon ni ni-building"></em>
                                                        <span class="small">{{ $invoice->patient->phone }}</span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="nk-block-head-content">
                                    <div class="d-flex gap g-3">
                                        <div class="gap-col">
                                            <div class="box-dotted py-2">
                                                <div class="d-flex align-items-center">
                                                    @if ($invoice->status === 'Paid')
                                                        <div class="h1 mb-0 text-success"><span class="small">TZS</span> {{ number_format($invoice->total_amount, 0) }}</div>
                                                    @else
                                                        <div class="h1 mb-0 text-danger"><span class="small">TZS</span> {{ number_format($invoice->total_amount, 0) }}</div>
                                                    @endif
                                                </div>
                                                <div class="smaller mt-3">Date: {{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') : 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="nk-block-head-between gap g-2 mt-4">
                                <div class="gap-col"></div>
                                <div class="gap-col">
                                    <ul class="d-flex gap g-2">
                                        {{-- Clear Bill (only show if invoice is NOT Paid and role is receptionist/admin) --}}
                                        @if (in_array(Auth::user()->role, ['receptionist', 'admin']) && $invoice->status !== 'Paid')
                                            <li class="d-none d-md-block">
                                                <form action="{{ route('invoices.clearBill', $invoice->id) }}" 
                                                      method="POST" onsubmit="return confirm('Are you sure you want to clear this bill?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-soft btn-primary">
                                                        <em class="icon ni ni-check"></em> Clear Bill
                                                    </button>
                                                </form>
                                            </li>
                                        @endif

                                        {{-- Cancel Invoice --}}
                                        @if (
                                            (Auth::user()->role === 'receptionist' && $invoice->status !== 'Paid') || 
                                            (Auth::user()->role === 'admin')
                                        )
                                            <li class="d-none d-md-block">
                                                <form action="{{ route('invoices.cancel', $invoice->id) }}" 
                                                      method="POST" onsubmit="return confirm('Are you sure you want to cancel this invoice?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-soft btn-danger">
                                                        <em class="icon ni ni-cross"></em> Cancel
                                                    </button>
                                                </form>
                                            </li>
                                        @endif

                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="nk-block">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane show active" id="tab-1" tabindex="0" role="tabpanel">
                                    <div class="card h-100 mt-4">
                                        <div class="card-body flex-grow-0 py-2">
                                            <div class="card-title-group">
                                                <div class="card-title">
                                                    <h4 class="title">Invoices Items</h4>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-middle mb-0">
                                                <thead class="table-light table-head-md">
                                                    <tr>
                                                        <th class="tb-col"><span class="overline-title">S/N</span></th>
                                                        <th class="tb-col"><span class="overline-title">Description</span></th>
                                                        <th class="tb-col tb-col-end tb-col-sm"><span class="overline-title">Qnty</span></th>
                                                        <th class="tb-col tb-col-end tb-col-sm"><span class="overline-title">Unit Price (TZS)</span></th>
                                                        <th class="tb-col tb-col-end tb-col-sm"><span class="overline-title">Total Amount (TZS)</span></th>
                                                        <th class="tb-col tb-col-end"><span class="overline-title">Actions</span></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($invoice->items as $key => $inv)
                                                        <tr>
                                                            <td class="tb-col">
                                                                <span class="small">{{ $key + 1 }}</span>
                                                            </td>
                                                            <td class="tb-col">
                                                                <span class="small">{{ $inv->description ?? 'N/A' }}</span>
                                                            </td>
                                                            <td class="tb-col tb-col-end tb-col-sm">
                                                                <span class="small">{{ number_format($inv->quantity, 0) }}</span>
                                                            </td>
                                                            <td class="tb-col tb-col-end tb-col-sm">
                                                                <span class="small">{{ number_format($inv->unit_price, 0) }}</span>
                                                            </td>
                                                            <td class="tb-col tb-col-end tb-col-sm">
                                                                <span class="small">{{ number_format($inv->total, 0) }}</span>
                                                            </td>
                                                            <td class="tb-col tb-col-end">
                                                                {{-- Remove Item --}}
                                                                @if ($invoice->status !== 'Paid' && in_array(Auth::user()->role, ['receptionist', 'admin', 'doctor']))
                                                                    <form action="{{ route('invoices.removeItem', [$invoice->id, $inv->id]) }}" 
                                                                          method="POST" onsubmit="return confirm('Are you sure you want to remove this item?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                                                                    </form>
                                                                @elseif ($invoice->status === 'Paid')
                                                                    <span class="badge bg-success">PAID</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="text-center text-muted">No invoice items found.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="card-footer text-center text-primary">
                                            Make sure all bills are cleared before going to next step.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger" role="alert">
                            Invoice not found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
