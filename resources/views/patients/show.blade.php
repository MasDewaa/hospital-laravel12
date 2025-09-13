@extends('layouts.app')

@section('title', 'Patient Details')
@section('page-title', 'Patient Details')

@section('page-actions')
    <a href="{{ route('patients.edit', $patient) }}" class="btn btn-warning me-2">
        <i class="fas fa-edit me-2"></i>Edit Patient
    </a>
    <a href="{{ route('patients.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Patients
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user me-2"></i>Patient Information
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Patient ID:</th>
                                <td><span class="badge bg-primary fs-6">{{ $patient->patient_id }}</span></td>
                            </tr>
                            <tr>
                                <th>Full Name:</th>
                                <td>{{ $patient->name }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth:</th>
                                <td>{{ $patient->date_of_birth->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <th>Age:</th>
                                <td>{{ $patient->date_of_birth->age }} years old</td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>{{ $patient->phone }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $patient->email ?? 'Not provided' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6><i class="fas fa-map-marker-alt me-2"></i>Address</h6>
                            <p class="text-muted">{{ $patient->address }}</p>
                        </div>
                        
                        @if($patient->medical_history)
                            <div class="mb-3">
                                <h6><i class="fas fa-file-medical me-2"></i>Medical History</h6>
                                <p class="text-muted">{{ $patient->medical_history }}</p>
                            </div>
                        @endif
                        
                        <div class="mb-3">
                            <h6><i class="fas fa-calendar me-2"></i>Registration Date</h6>
                            <p class="text-muted">{{ $patient->created_at->format('M d, Y \a\t H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-calendar-alt me-2"></i>Appointment History
                </h6>
            </div>
            <div class="card-body">
                @if($patient->appointments->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($patient->appointments->sortByDesc('appointment_date') as $appointment)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">{{ $appointment->doctor->name }}</h6>
                                        <p class="mb-1 text-muted">{{ $appointment->doctor->specialization }}</p>
                                        <small class="text-muted">
                                            {{ $appointment->appointment_date->format('M d, Y') }} at 
                                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                                        </small>
                                    </div>
                                    <span class="badge bg-{{ $appointment->status === 'scheduled' ? 'primary' : ($appointment->status === 'completed' ? 'success' : 'danger') }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>
                                @if($appointment->notes)
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <strong>Notes:</strong> {{ $appointment->notes }}
                                        </small>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center">No appointments found for this patient.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
