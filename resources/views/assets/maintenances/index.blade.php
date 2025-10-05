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
                                <h2 class="nk-block-title">{{ $asset->name }}</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('assets.asset.index') }}">Assets</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">{{ $asset->serial_number }}</li>
                                        <li class="breadcrumb-item active" aria-current="page">{{ $asset->name }}</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">
                                <ul class="d-flex">
                                    @if(in_array(Auth::user()->role, ['admin', 'owner']))
                                    <li>
                                        <a href="{{ route('assets.maintenances.create', $asset ) }}" class="btn btn-md d-md-none btn-primary" >
                                            <em class="icon ni ni-plus"></em>
                                            <span>Add</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('assets.maintenances.create', $asset ) }}" class="btn btn-primary d-none d-md-inline-flex" >
                                            <em class="icon ni ni-plus"></em>
                                            <span>Add Maintenance Record</span>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div><!-- .nk-block-head-between -->
                    </div><!-- .nk-block-head -->

                    <div class="nk-block">
                        <div class="card">
                            {{-- Assuming the table uses a third-party library like DataTables (datatable-init) --}}
                            <table class="datatable-init table" data-nk-container="table-responsive">
                                <thead class="table-light">
                                    <tr>
                                        <th class="tb-col">
                                            <span class="overline-title">Description</span>
                                        </th>
                                        <th class="tb-col">
                                            <span class="overline-title">Maintenance Date</span>
                                        </th>
                                        <th class="tb-col tb-col-xl">
                                            <span class="overline-title">Type</span>
                                        </th>
                                        <th class="tb-col tb-col-md">
                                            <span class="overline-title">Cost (TZS)</span>
                                        </th>
                                        <th class="tb-col ">
                                            <span class="overline-title">Performed By</span>
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
                                    {{-- Loop through the maintenance records --}}
                                    @forelse ($maintenances as $record)
                                    <tr>
                                        <td class="tb-col">
                                            <div class="media-group">
                                                <div class="media media-md media-middle media-circle text-bg-info-soft">
                                                    {{-- Display initials or a symbol --}}
                                                    <em class="icon ni ni-setting"></em>
                                                </div>
                                                <div class="media-text">
                                                    <span class="small text">{{ $record->details ?? 'No description' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- Table Data Cells Updated for Maintenance Records --}}
                                        <td class="tb-col">{{ \Carbon\Carbon::parse($record->maintenance_date)->format('M d, Y') }}</td>
                                        <td class="tb-col tb-col-xl">{{ $record->type }}</td>
                                        <td class="tb-col tb-col-md">{{ number_format($record->cost, 0) }}</td>
                                        <td class="tb-col ">{{ $record->performed_by }}</td>
                                        <td class="tb-col">
                                            @if ($record->status === 'Completed')
                                                <span class="badge text-bg-success-soft">{{ $record->status }}</span>
                                            @elseif ($record->status === 'Pending')
                                                <span class="badge text-bg-warning-soft">{{ $record->status }}</span>
                                            @else
                                                <span class="badge text-bg-success-soft">{{ 'Completed' }}</span>
                                            @endif
                                        </td>
                                        <td class="tb-col tb-col-end">
                                            <div class="dropdown">
                                                <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                    <em class="icon ni ni-more-v"></em>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                    <div class="dropdown-content py-1">
                                                        <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                            <li>
                                                                <a href="{{ route('assets.maintenances.edit', [$asset->id, $record->id]) }}">
                                                                    <em class="icon ni ni-edit"></em><span>Edit Record</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('assets.maintenances.destroy', [$asset->id, $record->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this maintenance record?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item">
                                                                        <em class="icon ni ni-trash"></em><span>Delete Record</span>
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('assets.maintenances.show', [$asset->id, $record->id] ) }}">
                                                                    <em class="icon ni ni-eye"></em><span>View Details</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div><!-- dropdown -->
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No maintenance records found for this asset.</td>
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
