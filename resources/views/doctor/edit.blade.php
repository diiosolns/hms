@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Doctor Panel - {{ $patient->first_name }} {{ $patient->last_name }}</h2>

    {{-- Prescriptions --}}
    <div class="card mb-3 mt-5">
        <div class="card-header">Prescriptions</div>
        <div class="card-body">
            <form action="{{ route('doctor.patient.prescriptions.update', $patient->id) }}" method="POST">
                @csrf
                <textarea name="prescription_notes" class="form-control" rows="3" placeholder="Enter prescription..."></textarea>
                <button type="submit" class="btn btn-primary mt-2">Save Prescription</button>
            </form>

            <ul class="mt-3">
                @foreach($patient->prescriptions as $p)
                    <li>{{ $p->notes }} (by Dr. {{ $p->doctor->name }})</li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Lab Tests --}}
    <div class="card mb-3">
        <div class="card-header">Lab Tests</div>
        <div class="card-body">
            <form action="{{ route('doctor.patient.labtests.update', $patient->id) }}" method="POST">
                @csrf
                <input type="text" name="test_name" class="form-control" placeholder="Enter lab test name">
                <button type="submit" class="btn btn-primary mt-2">Order Lab Test</button>
            </form>

            <ul class="mt-3">
                @foreach($patient->labRequests as $l)
                    <li>{{ $l->test_name }} - <strong>{{ $l->status }}</strong></li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Medical Records --}}
    <div class="card">
        <div class="card-header">Medical Records</div>
        <div class="card-body">
            <form action="{{ route('doctor.patient.records.update', $patient->id) }}" method="POST">
                @csrf
                <textarea name="record_notes" class="form-control" rows="3" placeholder="Enter medical notes..."></textarea>
                <button type="submit" class="btn btn-primary mt-2">Save Record</button>
            </form>

            <ul class="mt-3">
                @foreach($patient->medicalRecords as $r)
                    <li>{{ $r->notes }} (by Dr. {{ $r->doctor->name }})</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
