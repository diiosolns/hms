@extends('layouts.app')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2 align-items-center">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Add Pharmacy Stock</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('pharmacist.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add Stock</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="nk-block">
                    <div class="card card-gutter-md">
                        <div class="card-body">








                            {{-- Display Success or Error Messages --}}
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            {{-- Display Validation Errors --}}
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif








                            <form action="{{ route('pharmacist.stock.storeMultiple') }}" method="POST">
                                @csrf
                                <div id="stock-entries">
                                    <div class="row g-3 stock-entry mb-3">
                                        <!-- Pharmacy Item -->
                                        <div class="col-lg-3">
                                            <label for="pharmacy_item_id" class="form-label">Pharmacy Item</label>
                                            <select name="pharmacy_item_id[]" class="form-control" required>
                                                <option value="">Select Item</option>
                                                @foreach($items as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->code }})</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Type -->
                                        <div class="col-lg-2">
                                            <label for="type" class="form-label">Type</label>
                                            <select name="type[]" class="form-control" required>
                                                <option value="in">In</option>
                                                <option value="out">Out</option>
                                                <option value="adjustment">Adjustment</option>
                                            </select>
                                        </div>

                                        <!-- Quantity -->
                                        <div class="col-lg-2">
                                            <label for="quantity" class="form-label">Quantity</label>
                                            <input type="number" name="quantity[]" class="form-control" min="1" required>
                                        </div>

                                        <!-- Batch Number -->
                                        <div class="col-lg-2">
                                            <label for="batch_no" class="form-label">Batch No.</label>
                                            <input type="text" name="batch_no[]" class="form-control">
                                        </div>

                                        <!-- Expiry Date -->
                                        <div class="col-lg-2">
                                            <label for="expiry_date" class="form-label">Expiry Date</label>
                                            <input type="date" name="expiry_date[]" class="form-control">
                                        </div>

                                        <!-- Remove Button -->
                                        <div class="col-lg-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-entry">×</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add More Button -->
                                <div class="mb-3">
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="add-entry"> <em class="icon ni ni-plus"></em> <span>Add Another Item</span></button>
                                </div>

                                <!-- Reference -->
                                <div class="mb-3">
                                    <label for="reference" class="form-label">Reference</label>
                                    <input type="text" name="reference[]" class="form-control" placeholder="Purchase Order or Manual Entry">
                                </div>

                                <button type="submit" class="btn btn-primary">Save Stock</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- JS to add/remove rows dynamically --}}
@push('scripts')
<script>
    document.getElementById('add-entry').addEventListener('click', function () {
        let container = document.getElementById('stock-entries');
        let firstEntry = container.querySelector('.stock-entry');
        let newEntry = firstEntry.cloneNode(true);

        // Reset values
        newEntry.querySelectorAll('input, select').forEach(el => el.value = '');
        container.appendChild(newEntry);
    });

    document.addEventListener('click', function(e) {
        if(e.target && e.target.classList.contains('remove-entry')){
            let entries = document.querySelectorAll('.stock-entry');
            if(entries.length > 1){
                e.target.closest('.stock-entry').remove();
            } else {
                alert('At least one stock entry is required.');
            }
        }
    });
</script>
@endpush
@endsection
