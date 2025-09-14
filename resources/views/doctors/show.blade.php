@extends('layouts.app')

@section('title', 'Doctor Details')
@section('page-title', 'Doctor Information')

@section('page-actions')
    <div class="btn-group" role="group">
        <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Edit Doctor
        </a>
        <a href="{{ route('doctors.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Doctors
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-md me-2"></i>Doctor Information
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name:</label>
                            <p class="form-control-plaintext">{{ $doctor->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Specialization:</label>
                            <p class="form-control-plaintext">
                                <span class="badge bg-info fs-6">{{ $doctor->specialization }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Phone:</label>
                            <p class="form-control-plaintext">
                                <i class="fas fa-phone me-2"></i>{{ $doctor->phone }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email:</label>
                            <p class="form-control-plaintext">
                                <i class="fas fa-envelope me-2"></i>{{ $doctor->email }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">User Account:</label>
                            <p class="form-control-plaintext">
                                @if($doctor->user)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Active
                                    </span>
                                    <small class="text-muted d-block mt-1">
                                        Username: {{ $doctor->user->name }}
                                    </small>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>No Account
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Created:</label>
                            <p class="form-control-plaintext">
                                <i class="fas fa-calendar me-2"></i>{{ $doctor->created_at->format('M d, Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-bar me-2"></i>Statistics
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h4 class="text-primary">{{ $doctor->appointments->count() }}</h4>
                            <p class="text-muted mb-0">Total Appointments</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success">{{ $doctor->appointments->where('status', 'completed')->count() }}</h4>
                        <p class="text-muted mb-0">Completed</p>
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h4 class="text-warning">{{ $doctor->appointments->where('status', 'scheduled')->count() }}</h4>
                            <p class="text-muted mb-0">Scheduled</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-danger">{{ $doctor->appointments->where('status', 'cancelled')->count() }}</h4>
                        <p class="text-muted mb-0">Cancelled</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-calendar-alt me-2"></i>Recent Appointments
                </h6>
            </div>
            <div class="card-body">
                @if($doctor->appointments->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($doctor->appointments->take(5) as $appointment)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h6 class="mb-1">{{ $appointment->patient->name }}</h6>
                                    <small class="text-muted">
                                        {{ $appointment->appointment_date->format('M d, Y') }} at 
                                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                                    </small>
                                </div>
                                <span class="badge bg-{{ $appointment->status === 'scheduled' ? 'primary' : ($appointment->status === 'completed' ? 'success' : 'danger') }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                    @if($doctor->appointments->count() > 5)
                        <div class="text-center mt-3">
                            <a href="{{ route('appointments.index', ['doctor_id' => $doctor->id]) }}" class="btn btn-sm btn-outline-primary">
                                View All Appointments
                            </a>
                        </div>
                    @endif
                @else
                    <p class="text-muted text-center">No appointments yet</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
