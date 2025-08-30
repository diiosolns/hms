@extends('layouts.app')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Appointments</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    @if(Auth::user()->role === 'receptionist')
                                        <li class="breadcrumb-item"><a href="{{ route('receptionist.dashboard') }}">Dashboard</a></li>
                                    @elseif(Auth::user()->role === 'doctor')
                                        <li class="breadcrumb-item"><a href="{{ route('doctor.dashboard') }}">Dashboard</a></li>
                                    @elseif(Auth::user()->role === 'admin')
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    @endif
                                    <li class="breadcrumb-item active" aria-current="page">Manage Appointments</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="nk-block-head-content">
                            @if(Auth::user()->role === 'receptionist' || Auth::user()->role === 'admin')
                                <a href="{{ route('appointments.create') }}" class="btn btn-primary d-none d-md-inline-flex">
                                    <em class="icon ni ni-plus"></em>
                                    <span>Book Appointment</span>
                                </a>
                            @endif
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->

                <div class="nk-block">
                    <div class="card">
                        <table class="datatable-init table" data-nk-container="table-responsive">
                            <thead class="table-light">
                                <tr>
                                    <th class="tb-col"><span class="overline-title">Patient</span></th>
                                    <th class="tb-col"><span class="overline-title">Doctor</span></th>
                                    <th class="tb-col"><span class="overline-title">Date</span></th>
                                    <th class="tb-col"><span class="overline-title">Time</span></th>
                                    <th class="tb-col"><span class="overline-title">Reason</span></th>
                                    <th class="tb-col"><span class="overline-title">Status</span></th>
                                    <th class="tb-col tb-col-end" data-sortable="false">
                                        <span class="overline-title">Action</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($appointments as $appointment)
                                <tr>
                                    <td class="tb-col">{{ $appointment->patient->name ?? 'N/A' }}</td>
                                    <td class="tb-col">{{ $appointment->doctor->name ?? 'N/A' }}</td>
                                    <td class="tb-col">{{ $appointment->appointment_date }}</td>
                                    <td class="tb-col">{{ $appointment->appointment_time }}</td>
                                    <td class="tb-col">{{ $appointment->reason ?? '-' }}</td>
                                    <td class="tb-col">
                                        @if ($appointment->status === 'Scheduled')
                                            <span class="badge text-bg-info-soft">{{ $appointment->status }}</span>
                                        @elseif ($appointment->status === 'Completed')
                                            <span class="badge text-bg-success-soft">{{ $appointment->status }}</span>
                                        @else
                                            <span class="badge text-bg-danger-soft">{{ $appointment->status }}</span>
                                        @endif
                                    </td>
                                    <td class="tb-col tb-col-end">
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                <em class="icon ni ni-more-v"></em>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                    <li>
                                                        <a href="{{ route('appointments.show', $appointment->id) }}">
                                                            <em class="icon ni ni-eye"></em><span>View</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('appointments.edit', $appointment->id) }}">
                                                            <em class="icon ni ni-edit"></em><span>Edit</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item">
                                                                <em class="icon ni ni-trash"></em><span>Delete</span>
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div><!-- dropdown -->
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No appointments found.</td>
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
