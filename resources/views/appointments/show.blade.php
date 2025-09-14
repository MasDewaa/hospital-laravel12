@extends('layouts.app')

@section('title', 'Appointment Details')
@section('page-title', 'Appointment Information')

@section('page-actions')
    <div class="btn-group" role="group">
        <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Edit Appointment
        </a>
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Appointments
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-calendar-alt me-2"></i>Appointment Details
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Appointment Date:</label>
                            <p class="form-control-plaintext">
                                <i class="fas fa-calendar me-2"></i>{{ $appointment->appointment_date->format('l, F d, Y') }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Appointment Time:</label>
                            <p class="form-control-plaintext">
                                <i class="fas fa-clock me-2"></i>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status:</label>
                            <p class="form-control-plaintext">
                                <span class="badge bg-{{ $appointment->status === 'scheduled' ? 'primary' : ($appointment->status === 'completed' ? 'success' : 'danger') }} fs-6">
                                    <i class="fas fa-{{ $appointment->status === 'scheduled' ? 'clock' : ($appointment->status === 'completed' ? 'check' : 'times') }} me-1"></i>
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Created:</label>
                            <p class="form-control-plaintext">
                                <i class="fas fa-calendar-plus me-2"></i>{{ $appointment->created_at->format('M d, Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                @if($appointment->notes)
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Notes:</label>
                            <div class="form-control-plaintext bg-light p-3 rounded">
                                <i class="fas fa-sticky-note me-2"></i>{{ $appointment->notes }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Patient Information -->
        <div class="card shadow mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user me-2"></i>Patient Information
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Patient Name:</label>
                            <p class="form-control-plaintext">{{ $appointment->patient->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Patient ID:</label>
                            <p class="form-control-plaintext">
                                <span class="badge bg-secondary fs-6">{{ $appointment->patient->patient_id }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Date of Birth:</label>
                            <p class="form-control-plaintext">
                                <i class="fas fa-birthday-cake me-2"></i>{{ $appointment->patient->date_of_birth->format('M d, Y') }}
                                <small class="text-muted">({{ $appointment->patient->date_of_birth->age }} years old)</small>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Phone:</label>
                            <p class="form-control-plaintext">
                                <i class="fas fa-phone me-2"></i>{{ $appointment->patient->phone }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email:</label>
                            <p class="form-control-plaintext">
                                <i class="fas fa-envelope me-2"></i>{{ $appointment->patient->email }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Address:</label>
                            <p class="form-control-plaintext">
                                <i class="fas fa-map-marker-alt me-2"></i>{{ $appointment->patient->address }}
                            </p>
                        </div>
                    </div>
                </div>

                @if($appointment->patient->medical_history)
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Medical History:</label>
                            <div class="form-control-plaintext bg-light p-3 rounded">
                                <i class="fas fa-file-medical me-2"></i>{{ $appointment->patient->medical_history }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Doctor Information -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-md me-2"></i>Doctor Information
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="fas fa-user-md fa-3x text-primary mb-2"></i>
                    <h5>{{ $appointment->doctor->name }}</h5>
                    <span class="badge bg-info fs-6">{{ $appointment->doctor->specialization }}</span>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Phone:</label>
                    <p class="form-control-plaintext">
                        <i class="fas fa-phone me-2"></i>{{ $appointment->doctor->phone }}
                    </p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Email:</label>
                    <p class="form-control-plaintext">
                        <i class="fas fa-envelope me-2"></i>{{ $appointment->doctor->email }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($appointment->status === 'scheduled')
                        <form method="POST" action="{{ route('appointments.update', $appointment) }}" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="btn btn-success w-100" 
                                    onclick="return confirm('Mark this appointment as completed?')">
                                <i class="fas fa-check me-2"></i>Mark as Completed
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('appointments.update', $appointment) }}" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="btn btn-danger w-100" 
                                    onclick="return confirm('Cancel this appointment?')">
                                <i class="fas fa-times me-2"></i>Cancel Appointment
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Appointment
                    </a>
                    
                    <a href="{{ route('patients.show', $appointment->patient) }}" class="btn btn-info">
                        <i class="fas fa-user me-2"></i>View Patient Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Appointment History -->
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-history me-2"></i>Recent Appointments
                </h6>
            </div>
            <div class="card-body">
                @php
                    $recentAppointments = \App\Models\Appointment::where('patient_id', $appointment->patient_id)
                        ->where('id', '!=', $appointment->id)
                        ->orderBy('appointment_date', 'desc')
                        ->take(3)
                        ->get();
                @endphp
                
                @if($recentAppointments->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentAppointments as $recent)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h6 class="mb-1">{{ $recent->doctor->name }}</h6>
                                    <small class="text-muted">
                                        {{ $recent->appointment_date->format('M d, Y') }} at 
                                        {{ \Carbon\Carbon::parse($recent->appointment_time)->format('H:i') }}
                                    </small>
                                </div>
                                <span class="badge bg-{{ $recent->status === 'scheduled' ? 'primary' : ($recent->status === 'completed' ? 'success' : 'danger') }}">
                                    {{ ucfirst($recent->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center">No previous appointments</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
